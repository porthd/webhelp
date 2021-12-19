<?php

namespace Porthd\Webhelp\ViewHelpers;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de>
 *
 *  All rights reserved
 *
 *  This script is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 */

use DateInterval;
use DateTime;
use Porthd\Webhelp\Config\WebhelpConf;
use Porthd\Webhelp\Exception\DieException;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class EasyICalendarViewHelper extends AbstractTagBasedViewHelper
{

    use TraitInfofileViewHelper;

    protected const SELF_NAME = 'easyICalendar';

    protected const ARG_DESCRIPTION = 'description';
    protected const ARG_LOCATION = 'location';
    protected const ARG_ORGANIZER = 'organizer';
    protected const ARG_CONTACT = 'contact';
    protected const ARG_SUMMARY = 'summary';
    protected const ARG_URL = 'url';
    protected const ARG_UID = 'uid';
    protected const ARG_DATESTART = 'dateStart';
    protected const ARG_DATE_FORMAT = 'dateFormat';
    protected const ARG_DATE_UTC = 'dateUtc';
    protected const ARG_DATE_ONLY = 'dateOnly';
    protected const ARG_DATEEND = 'dateEnd';
    protected const ARG_DURATION = 'duration';

    protected const ARG_FILE_NAME = 'fileName';
    protected const DEFAULT_FILE_NAME = 'invitation.ics';
    protected const ARG_JSON_DATA = 'jsonData';
    protected const ARG_FLUID_DATA = 'fluidData';// No free name selection allowed
    protected const ARG_MAPPING = 'mapping';

    protected const OUT_TAG_NAME = 'eventJson';


    protected const ARG_MAIN_LIST = [
        self::ARG_DESCRIPTION => 'The text describes fully the event.',
        self::ARG_LOCATION => 'the location may be an address, a link or a description of the location.',
        self::ARG_SUMMARY => 'The summary means the title of the event.',
        self::ARG_UID => 'The link contains detailed information about the event. If it is missing,  The link will be used as UID. If both missing, the viewhelper will fail.',
        self::ARG_URL => 'The link contains detailed information about the event. The link will be used as UID',
        self::ARG_DATESTART => 'This define the start of the event.',

        self::ARG_DATEEND => 'This define the (estimated) end of the event.',
        self::ARG_DURATION => 'This define the (estimated) end of the event.',
        self::ARG_ORGANIZER => 'The field must contain the name of the organizer.',
        self::ARG_CONTACT => 'The field contains the email or other informations about the contact.',
    ];

    /**
     * @var string
     */
    protected $tagName = 'easy-icalendar';


    protected $flagProduction = true;

    /**
     * Initialize arguments,
     *    a) which are the general TYPO3-Arguments
     *    b) which are related to every editor-viewhelper
     *    c) which are related to the selected editor for the editor-viewhelper
     * You can activate the logger.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        foreach (self::ARG_MAIN_LIST as $name => $info) {
            $this->registerArgument($name, 'string', $info, false);
        }

        $this->registerArgument(self::ARG_DATE_UTC, 'bool',
            'Default is `false`. If it is true, there will used the UTC-timezone. If it is false, there will used the local timezone. ',
            false, false);
        $this->registerArgument(self::ARG_DATE_ONLY, 'bool',
            'Default is `false`. If it is true, there will only a date defined.',
            false, false);
        $this->registerArgument(self::ARG_DATE_FORMAT, 'string',
            'This define the format of the date event for date_create_from_format.',
            false, self::DEFAULT_FILE_NAME);
        $this->registerArgument(self::ARG_FILE_NAME, 'string',
            'The field must contain the name of the downloaded file.',
            false, self::DEFAULT_FILE_NAME);
        $this->registerArgument(self::ARG_JSON_DATA, 'string',
            'The strings contains a JSON-object or better an associative array, with all needed fields `description`, `location`, `summary`, `url`, `dateStart and dateEnd`.',
            false);
        $this->registerArgument(self::ARG_FLUID_DATA, 'array',
            'The associative array or fluid-model with getter-methods contains  all needed fields `description`, `location`, `summary`, `url`, `dateStart and dateEnd`.',
            false, []);
        $this->registerArgument(self::ARG_MAPPING, 'string',
            'If the Keys of the data-array and the neede field have different names, you can map them. The key in this array mean the key in the source-data-array. The value mean the needed key, which is the name of the attribute in the web component. This will have only an effect, if the field jsonData or the field fluidData is filled.',
            false);

    }

    /**
     * render only children-context or warp children-context in <easy-icalendar>-tag
     *
     * The mechanims in the render part is simple:
     * 1. read and merge data
     *    a. each define in single parameters of the viewhelper
     *    b. defined in a fluid-Object oder array
     *    c. define in a JSON-string
     * 2. Validate and normalize the data
     * 3. wirte the data to the attribute `eventJson` in the webcomponet easy-icalendar. the javascript of the webcomponent does the rest.
     *
     * Remark/Security!!!: you can change on the website the data in eventJson, to get another vCard-file. The datas have no effect on the server.
     *
     *
     * @return mixed|string
     * @throws AspectNotFoundException
     */
    public function render()
    {
        if (!empty($this->arguments[self::OUT_TAG_NAME])) {
            throw new DieException(
                'The argument `' . self::OUT_TAG_NAME . '` is forbidden in this viewhelper `' . self::SELF_NAME . '`.',
                1627754567
            );
        }

        $jsonData = $this->arguments[self::ARG_JSON_DATA] ?? '';
        $fluidData = $this->arguments[self::ARG_FLUID_DATA] ?? null;
        $data = $this->mergeDataFromThreeSources(
            $this->arguments,
            self::ARG_MAIN_LIST,
            $fluidData,
            $jsonData

        );

        /* Parameter by ref */
        $flagNeeded = $this->checkDataList($data);
        $flagNeeded = $flagNeeded && $this->checkDatesAndNormalize($data);

        if ($flagNeeded) {
            $this->normalizeDataList($data);
            $this->tag->addAttribute(
                self::OUT_TAG_NAME,
                json_encode($data)
            );
            /* helpful about the parameter für the calendar - not needed in production */
            if ((strpos(strtolower(Environment::getContext()),
                        WebhelpConf::TYPO3_CONTEXT_DEVELOPMENT) === 0) || (true)) {
                $keyList = array_keys($data);
                foreach ($keyList as $key) {
                    $this->tag->removeAttribute($key);
                }
            }

            $this->tag->setContent($this->renderChildren());
            $this->tag->forceClosingTag(true);
            $result = $this->tag->render();
        } else {
            $result = $this->renderChildren();
        }
        return $result;
    }


    /**
     * @param array $data
     */
    protected function normalizeDataList(array &$data)
    {
        if (empty($data[self::ARG_UID])) {
            $data[self::ARG_UID] = $data[self::ARG_URL];
        }
        if (empty($data[self::ARG_URL])) {
            $data[self::ARG_URL] = $data[self::ARG_UID];
        }
        if (empty($data[self::ARG_DESCRIPTION])) {
            $data[self::ARG_DESCRIPTION] = $data[self::ARG_SUMMARY];
        }
        // only string no more specific normalisation
        // ARG_DESCRIPTION, ARG_LOCATION, ARG_ORGANIZER, ARG_CONTACT, ARG_SUMMARY, ARG_URL, ARG_UID;

        // while checking  normalized ARG_DATESTART, ARG_DATEEND, ARG_DURATION

        $data[self::ARG_FILE_NAME] = $this->normalizeFileName($data[self::ARG_FILE_NAME]);
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function checkDatesAndNormalize(array &$data): bool
    {
        $format = $data[self::ARG_DATE_FORMAT] ?? '';
        $onlyDate = $data[self::ARG_DATE_ONLY] ?? false;
        $utcDate = $data[self::ARG_DATE_UTC] ?? false;
        $endDate = $data[self::ARG_DATEEND] ?? '';
        $startDate = $data[self::ARG_DATESTART] ?? '';
        $flag = true;
        [$flag, $data[self::ARG_DATESTART]] = $this->checkDateFormat($flag, $startDate, $format, $onlyDate, $utcDate);
        if ($flag) {
            if (!empty($endDate)) {
                [$flag, $data[self::ARG_DATEEND]] = $this->checkDateFormat($flag, $endDate, $format, $onlyDate,
                    $utcDate);
            } else {
                $flag = $flag && ((new DateInterval($data[self::ARG_DURATION])) !== false);
            }
        }
        return $flag;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function checkDataList(array &$data): bool
    {
        $flagNeeded = true;
        foreach ([
                     self::ARG_LOCATION,
                     self::ARG_SUMMARY,
                     self::ARG_ORGANIZER,
                     self::ARG_DATESTART,
                 ] as $name
        ) {
            $flagNeeded = $flagNeeded && (!empty($data[$name]));
        }
        $flagNeeded = $flagNeeded && (
                (!empty($data[self::ARG_UID])) ||
                (!empty($data[self::ARG_URL]))
            );
        $flagNeeded = $flagNeeded && (
                (!empty($data[self::ARG_DATEEND])) ||
                (!empty($data[self::ARG_DURATION]))
            );

        return $flagNeeded;
    }

    /**
     * @param $format
     * @param $startDate
     * @param bool $flag
     * @param $onlyDate
     * @param $utcDate
     * @param $data
     * @return array
     * @throws \Exception
     */
    protected function checkDateFormat(bool $flag, $startDate, $format, $onlyDate, $utcDate): array
    {
        if ((!$flag) ||
            (empty($startDate))
        ) {
            return [$flag, ''];
        }

        $resultDate = '';
        if (empty($format)) {
            $time = strtotime($startDate);
            $flag = $flag && ($time !== false);
            if ($flag) {
                $myTime = new DateTime('@' . $time);
            }
        } else {
            $myTime = date_create_from_format($format, $startDate);
            $flag = $flag && ($myTime !== false);
        }
        if ($flag) {
            if ($onlyDate) {
                $resultDate = $myTime->format('Ymd');
            } else {
                $resultDate = $myTime->format('Ymd') . 'T' . $myTime->format('His');
                if ($utcDate) {
                    $startDate .= 'Z';
                }
            }
        }

        return [$flag, $resultDate];
    }
}
