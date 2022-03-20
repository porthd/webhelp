<?php

namespace Porthd\Webhelp\ViewHelpers;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de> - TYPO3-developer
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
 * see analogous examples with viewhelperattribute `mapping`, 'fluidData' and 'jsonData' in viewhelper easyICalendar
 *
 * example input (TYPO3-template)
 * -------------------------------
 *     <webhelp:easyVCard
 *                        n="Porth;Dieter;;Dr;"
 *                        fn="Dr. Dieter Porth"
 *                        adr="{first:';;Grünenstraße 23;Bremen;;28199;Germany'}"
 *                        adrtype="{first:'TYPE=home;LABEL=\"Grünenstraße 23\n28199 Bremen\nDeutschland\"'}"
 *                        email="info@mobger.de"
 *                        tel="{first: 'tel:049-421-51483548', second:'+49-160-99180688'}"
 *                        teltype="{first:'TYPE=home,voice',second:'TYPE=mobile,voice'}"
 *                        url="https://www.düddelei.de"
 *                        uid="https://www.mobger.de/"
 *                        role="TYPO3-Developer"
 *     >
 *         my Imprint (detailData needed)
 *     </webhelp:easyVCard>
 *
 * example output
 * ===============================
 *    <easy-vcard eventJson="{&quot;n&quot;:&quot;Porth;Dieter;;Dr;&quot;,&quot;uid&quot;:&quot;https:\/\/www.d\u00fcddelei.de&quot;,&quot;email&quot;:&quot;info@mobger.de&quot;,&quot;fn&quot;:&quot;Dr. Dieter Porth&quot;,&quot;geo&quot;:&quot;&quot;,&quot;logo&quot;:&quot;&quot;,&quot;note&quot;:&quot;&quot;,&quot;org&quot;:&quot;private&quot;,&quot;photo&quot;:&quot;&quot;,&quot;role&quot;:&quot;TYPO3-Developer&quot;,&quot;tz&quot;:&quot;&quot;,&quot;url&quot;:&quot;https:\/\/www.d\u00fcddelei.de&quot;,&quot;adr&quot;:[&quot;;TYPE=TYPE=home;LABEL=\&quot;Gr\u00fcnenstra\u00dfe 23\\n28199 Bremen\\nDeutschland\&quot;:;;Gr\u00fcnenstra\u00dfe 23;Bremen;;28199;Germany&quot;],&quot;key&quot;:&quot;&quot;,&quot;keytype&quot;:&quot;&quot;,&quot;tel&quot;:[&quot;;MEDIATYPE=TYPE=mobile,voice:+49-160-99180688&quot;,&quot;;MEDIATYPE=TYPE=home,voice:tel:049-421-51483548&quot;],&quot;filename&quot;:&quot;&quot;}">
 *        my Imprint (detailData needed)
 *    </easy-vcard>
 */

use Porthd\Webhelp\Config\WebhelpConf;
use Porthd\Webhelp\Exception\DieException;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class EasyVCardViewHelper extends AbstractTagBasedViewHelper
{
    use TraitInfofileViewHelper;

    protected const SELF_NAME = 'easyVCard';

    protected const ARG_EMAIL = 'email';
    protected const ARG_FULLNAME = 'fn';   // Resultstring must contain Uri with exchangeformatname 'geo:' like  GEO:geo:float,float
    protected const ARG_GEO = 'geo';   // Resultstring must contain Uri with exchangeformatname 'geo:' like  GEO:geo:float,float
    protected const ARG_KEY = 'key';  // Array
    protected const ARG_KEY_TYPE = 'keytype';  // Array
    protected const ARG_ADR = 'adr'; // adress  // Array
    protected const ARG_ADR_TYPE = 'adrtype'; // home  // Array
    protected const ARG_LOGO = 'logo';   // Sting must contain :
    protected const ARG_N = 'n'; // Name
    protected const ARG_NOTE = 'note';
    protected const ARG_ORG = 'org';
    protected const ARG_PHOTO = 'photo';  // Sting must contain :
    protected const ARG_ROLE = 'role';
    protected const ARG_TEL = 'tel';  // Array
    protected const ARG_TEL_TYPE = 'teltype';  // Array
    protected const ARG_TITLE = 'title';
    protected const ARG_TIMEZONE = 'tz';
    protected const ARG_UID = 'uid';
    protected const ARG_URL = 'url';

    protected const ARG_FILE_NAME = 'filename';
    protected const DEFAULT_FILE_NAME = 'vcard.ics';

    protected const ARG_JSON_DATA = 'jsonData';
    protected const ARG_FLUID_DATA = 'fluidData';// No free name selection allowed
    protected const ARG_MAPPING = 'mapping';

    protected const ATTR_EVENT_JSON = 'eventJson';
    protected const OUT_TAG_NAME = self::ATTR_EVENT_JSON;


    /**
     * @var string
     */
    protected $tagName = 'easy-vcard';

    protected const ARG_MUST_LIST = [
        //self::ARG_VERSION => 'This contains the version of the VCard (ever: 4.0)',
        self::ARG_N => 'This contains the fiefe colon-separated list of parts of a name. It looks like N:Mustermann;Erika;von;Dr.;`',
        self::ARG_UID => 'This ist the uid of the person. It is needed for synchronidation-things.',

    ];

    protected const ARG_ARRAY_LIST = [
        self::ARG_ADR => 'This array,contains the colon-separated list of Address informations linke `(Company);(department);(PostalStreet No.);(town));(State);(ZIP);(Nation)`',
        self::ARG_ADR_TYPE => 'This contains the structured. (home)',
        self::ARG_KEY => 'This parameter contain the public key of a Participant or the link to the public key. It will be BASE64 encoded. (optional)',
        self::ARG_KEY_TYPE => 'This parameter contain tha TYPE of th public key. It is needed, if the key is given. (optional)',
        self::ARG_TEL => 'This contains a colon-separated list of Telefonnumbers. (optional)',
        self::ARG_TEL_TYPE => 'This contains a colon-separated list of Telefonnumbers-types. This is coroponding to the telefon-number-list. (optional)',
    ];

    protected const ARG_ARRAYPAIR_LIST = [
        self::ARG_ADR => [self::ARG_ADR_TYPE, ';TYPE=',],
        self::ARG_KEY => [self::ARG_KEY_TYPE, ';MEDIATYPE=',],
        self::ARG_TEL => [self::ARG_TEL_TYPE, ';MEDIATYPE=',],
    ];
    protected const ARG_OPTINAL_LIST = [
        self::ARG_EMAIL => 'This contains the Email of the contact. (optional))',
        self::ARG_FULLNAME => 'This parameter contain a full name of the contact(optional)',
        self::ARG_GEO => 'This parameter contain a comma-separated list with the floatvalue of latitude and longitude like `GEO:geo: 50.858\,7.0885` (optional)',
        self::ARG_LOGO => 'This contains the link to a logo of organisation. It will be BASE64 encoded. The extension defines the type. (Optional) ',
        self::ARG_NOTE => 'This contain some free text.',
        self::ARG_ORG => 'This contains the name of the organisation. (default: `private`)',
        self::ARG_PHOTO => 'This contains the link to a photo of the person. It will be BASE64 encoded. The extension defines the type. (Optional) ',
        self::ARG_ROLE => 'This contain the role in the organisation: (Default: ``)',
        self::ARG_TIMEZONE => 'This is the timezone for the contact.',
        self::ARG_URL => 'This is the URL to a personla page of the user.',
    ];


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
        $list = array_merge(self::ARG_MUST_LIST, self::ARG_OPTINAL_LIST);
        foreach ($list as $name => $info) {
            $this->registerArgument($name, 'string', $info, false);
        }
        foreach (self::ARG_ARRAY_LIST as $name => $info) {
            $this->registerArgument($name, 'array', $info, false);
        }
        $this->registerArgument(self::ARG_JSON_DATA, 'string',
            'The strings contains a JSON-object or better an associative array, with all needed fields `description`, `location`, `summary`, `url`, `dateStart and dateEnd`.',
            false);
        $this->registerArgument(self::ARG_FLUID_DATA, 'array',
            'The associative array or fluid-model with getter-methods contains  all needed fields `description`, `location`, `summary`, `url`, `dateStart and dateEnd`.',
            false, []);
        $this->registerArgument(self::ARG_MAPPING, 'string',
            'If the Keys of the data-array and the neede field have different names, you can map them. The key in this array mean the key in the source-data-array. The value mean the needed key, which is the name of the attribute in the web component. This will have only an effect, if the field jsonData or the field fluidData is filled.',
            false);

        $this->registerTagAttribute(self::OUT_TAG_NAME, 'string',
            'All the needed datas are shown as a json-String in this tag-attribute. If this is used, all other arguments are ignored.',
            false);
    }

    /**
     * render only children-context or warp children-context in <easy-vcard>-tag
     *  The requierements are
     *  a) instanciated editor-class
     *
     * The mechanims in the render part is simple:
     * 1. read and merge data
     *    a. each define in single parameters of the viewhelper
     *    b. defined in a fluid-Object oder array
     *    c. define in a JSON-string
     * 2. Validate and normalize the data
     * 3. wirte the data to the attribute `eventJson` in the webcomponet easy-vcard. the javascript of the webcomponent does the rest.
     *
     * Remark/Security!!!: you can change on the website the data in eventJson, to get another vCard-file. The datas have no effect on the server.
     *
     * @return mixed|string
     * @throws AspectNotFoundException
     */
    public function render()
    {
        if (!empty($this->arguments[self::OUT_TAG_NAME])) {
            throw new DieException(
                'The argument `' . self::OUT_TAG_NAME . '` is forbidden in this viewhelper `' . self::SELF_NAME . '`.',
                1627754566
            );
        }

        $jsonData = $this->arguments[self::ARG_JSON_DATA] ?? '';
        $fluidData = $this->arguments[self::ARG_FLUID_DATA] ?? null;

        $list = array_merge(self::ARG_MUST_LIST, self::ARG_OPTINAL_LIST, self::ARG_ARRAY_LIST);
        $data = $this->mergeDataFromThreeSources(
            $this->arguments,
            $list,
            $fluidData,
            $jsonData

        );


        /* Parameter by ref */
        $flagNeeded = $this->checkDataList($data);

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
     * @return bool
     */
    protected function checkDataList(array &$data): bool
    {
        $flagNeeded = true;
        $keyList = array_keys(self::ARG_MUST_LIST);
        $keyList[] = self::ARG_ADR;
        foreach ($keyList as $name) {
            $flagNeeded = $flagNeeded && (!empty($data[$name]));
        }
        $flagNeeded = $flagNeeded && (!empty($data[self::ARG_ADR]))
            && (!empty($data[self::ARG_ADR_TYPE]));
        $flagNeeded = $flagNeeded && (
                (!empty($data[self::ARG_UID])) ||
                (!empty($data[self::ARG_URL]))
            );
        if ($flagNeeded && (!empty($data[self::ARG_URL]))) {
            $flagNeeded = $flagNeeded && (filter_var($data[self::ARG_URL], FILTER_SANITIZE_URL) !== false);
        }
        if ($flagNeeded) {
            $test = explode(';', $data[self::ARG_N]);
            $flagNeeded = $flagNeeded && (count($test) === 5);
        }
        if ($flagNeeded) {

            $test =$data[self::ARG_ADR];
            if (!empty($test)) {
                foreach($test as $item) {
                    $check = explode(';', $item);
                    $flagNeeded = $flagNeeded && (count($check)===7);
                }
            } else {
                $flagNeeded = $flagNeeded && (false);
            }

        }
        foreach (self::ARG_ARRAYPAIR_LIST as $main => $prefix) {
            $flagNeeded = $flagNeeded && (
                    (empty($data[$main])) ||
                    (count($data[$main]) === count($data[$prefix[0]]))
                );
        }

        return $flagNeeded;
    }


    /**
     * @param array $data
     */
    protected function normalizeDataList(array &$data): void
    {
        foreach (self::ARG_ARRAYPAIR_LIST as $main => $prefix) {
            if (!empty($data[$main])) {
                $listData = array_values($data[$main]);
                $prefixData = array_values($data[$prefix[0]]);
                unset($data[$prefix[0]]);
                $result = [];
                for ($i = count($listData) - 1; $i >= 0; $i--) {
                    if (empty($prefixData[$i])) {
                        $result[] = ':' . $listData[$i];
                    } else {
                        $result[] = $prefix[1] . $prefixData[$i] . ':' . $listData[$i];
                    }
                }
                $data[$main] = $result;
            }
        }

        if ((!empty($data[self::ARG_EMAIL])) &&
            (filter_var($data[self::ARG_EMAIL], FILTER_VALIDATE_EMAIL) === false)
        ) {
            unset($data[self::ARG_EMAIL]);
        }
        if ((empty($data[self::ARG_FULLNAME])) &&
            (!empty($data[self::ARG_N]))
        ) {
            $test = explode(';', $data[self::ARG_N]);
            $result = '';
            for ($i = count($test) - 1; $i >= 0; $i--) {
                $result = trim($result . ' ' . $test[$i]);
            }
            $data[self::ARG_FULLNAME] = $result;
        }
        if (!empty($data[self::ARG_GEO])) {
            $part = explode(':', $data[self::ARG_GEO]);
            if (count($part) === 1) {
                $pair = $part[0];
                $start = 'geo';
            } else {
                if (count($part) === 2) {
                    $pair = $part[1];
                    $start = $part[0];
                }
            }
            $floats = explode(',', $pair);
            if ((is_numeric($floats[0])) && (is_numeric($floats[1])) &&
                (-90 <= $floats[0]) && (90 >= $floats[0]) &&
                (-180 <= $floats[1]) && (180 >= $floats[1])) {
                $data[self::ARG_GEO] = $start . ':' . $floats[0] . ',' . $floats[1];
            } else {
                unset($data[self::ARG_GEO]);
            }
        }

        if (empty($data[self::ARG_ORG])) {
            $data[self::ARG_ORG] = 'private';
        }

        foreach ([self::ARG_LOGO, self::ARG_PHOTO] as $photoStuff) {
            if (!empty($data[$photoStuff])) {
                $test = $data[$photoStuff];
                if (strpos($test, 'data:') === 0) {
                    $data[$photoStuff] = ':' . $test;
                } else {
                    $check = strtolower(strrchr($test, '.')); // the extension contains the
                    // see https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types 20210801

                    switch ($check) {
                        case 'apng':
                            $type = 'image/apng';
                            break;
                        case 'avif':
                            $type = 'image/avif';
                            break;
                        case 'bmp':
                            $type = 'image/bmp';
                            break;
                        case 'gif':
                            $type = 'image/gif';
                            break;
                        case 'jfif':
                        case 'jpe':
                        case 'jpeg':
                        case 'jpg':
                        case 'pjp':
                        case 'pjpeg':
                            $type = 'image/jpeg';
                            break;
                        case 'png':
                            $type = 'image/png';
                            break;
                            break;
                        case 'tiff':
                        case 'tif':
                            $type = 'image/tiff';
                            break;
                        case 'svg':
                            $type = 'image/svg+xml';
                            break;
                        case 'webp':
                            $type = 'image/webp';
                            break;
                        default :
                            $type='';
                            break;
                    }
                    if (empty($type)) {
                        unset($data[$photoStuff]);
                    } else {
                        $data[$photoStuff] = ';MEDIATYPE=' . $type . ':' . $test;
                    }
                }
            }
        }

        if (!empty($data[self::ARG_UID])) {
            $data[self::ARG_UID] = $data[self::ARG_URL];
        }

        $data[self::ARG_FILE_NAME] = $this->normalizeFileName($data[self::ARG_FILE_NAME]);

    }

}
