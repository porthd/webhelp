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
 *
 * Some exampeles
 *
 * TYPO3-Fluidtemplate:
 * --------------------
 * <div>
 *     <webhelp:EasyTextLogo value="Hallo Welt, morgen sind wir schon weiter. Heute stehen wir vor dem Abgrund; die Hungerkriege haben längst begonnen, wie die Corona-Maßnahmen in den Entwicklungsländern zeigen."
 *                           logopath="EXT:webhelp/Resources/Public/Icons/Cursor/DownloadCursor.svg"
 *     />
 * </div>
 *
 * Output (Frontend-HTML / Firefox):
 * -----------------------
 * <div>
 *    <popup-info value="Hallo Welt, morgen sind wir schon weiter. Heute stehen wir vor dem Abgrund; die Hungerkriege haben längst begonnen, wie die Corona-Maßnahmen in den Entwicklungsländern zeigen." logopath="EXT:webhelp/Resources/Public/Icons/Cursor/DownloadCursor.svg" my-text-json="&quot;Hallo Welt, morgen sind wir schon weiter. Heute stehen wir vor dem Abgrund; die Hungerkriege haben l\u00e4ngst begonnen, wie die Corona-Ma\u00dfnahmen in den Entwicklungsl\u00e4ndern zeigen.&quot;" my-logo="/typo3conf/ext/webhelp/Resources/Public/Icons/Cursor/DownloadCursor.svg"></popup-info>
 * </div>
 *
 *
 * TYPO3-Fluidtemplate:
 * --------------------
 * <div>
 *     <webhelp:EasyTextLogo value="Hallo Welt, alles ist super; dann vieler Politiker, die +über Forschung und Technik reden, oder?" />
 * </div>
 *
 * Output (Frontend-HTML / Firefox):
 * -----------------------
 * <div>
 *     <popup-info value="Hallo Welt, alles ist Super" my-ext="Hallo Welt, alles ist Super" my-logo=""></popup-info>
 * </div>
 *
 *
 * TYPO3-Fluidtemplate:
 * --------------------
 * <webhelp:easyTextLogo>
 *     <h1>Hallo Welt,</h1>
 *     <div>Ohne Klimaschutzmaßnahmen muss bis 2050 die Menschheitsmasse auf 4G Menschen ausgedünnt werden, weil Öl und Phosphate als Dünger fehlen. <br /> Ohne Klimaschutzmaßnahmen wird dank Verbot der Pfanzenschutzmitteln 2050 die Menschheitsmasse durch Verhungern auf 3G Menschen ausgedünnt. Öl und Phosphate als Dünger fehlen auch dann, weil die Rohstoffe in Elektroautos investiert wurden. <br > Heil dem Ökofaschismus!</div>
 * </webhelp:easyTextLogo>
 *
 * Output (Frontend-HTML / Firefox):
 * -----------------------
 * <div>
 *     <popup-info my-ext="
 *                     &amp;lt;h1&amp;gt;Hallo Welt&amp;lt;/h1&amp;gt;&amp;lt;div&amp;gt;alles ist Super.&amp;lt;/div&amp;gt;
 *                 " my-logo=""></popup-info>
 * </div>
 */

use Porthd\Webhelp\Config\WebhelpConf;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class EasyTextLogoViewHelper extends AbstractTagBasedViewHelper
{
    protected const SELF_NAME = 'easyTextLogo';

    protected const ARG_TAG_NAME = 'tagName';
    protected const DEFAULT_TAG_NAME = 'popup-info';
    protected const ARG_VALUE = 'value';
    protected const ARG_LOGOPATH = 'logopath';
    protected const OUT_TEXT = 'my-text-json';
    protected const OUT_LOGO = 'my-logo';


    protected const ARG_MAIN_LIST = [
        self::ARG_TAG_NAME => 'The tag-name name the webcomponent for usage.',
        self::ARG_VALUE => 'If there is text in the value-attribute, the html-text included by the tags will be ignored.',
        self::ARG_LOGOPATH => 'This ist an optional attribute. The webcomponent have to deal with a missing-logoPath.',
    ];

    /**
     * @var string
     */
    protected $tagName = self::DEFAULT_TAG_NAME;

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
            $this->registerTagAttribute($name, 'string', $info, false);
        }
    }

    /**
     * render a webcompomnent, which can use the a HTML-text and only children-context or warp children-context in <popup-info>-tag
     *  The requierements are
     *  a) instanciated editor-class
     *
     */
    public function render()
    {
        $this->tagName = $this->arguments[self::ARG_TAG_NAME] ?? self::DEFAULT_TAG_NAME;
        /* helpful about the parameter für the calendar - not needed in production */
        if (strpos(strtolower(Environment::getContext()), WebhelpConf::TYPO3_CONTEXT_DEVELOPMENT) !== 0) {
            $keyList = array_keys(self::ARG_MAIN_LIST);
            foreach ($keyList as $key) {
                $this->tag->removeAttribute($key);
            }
        }
        $logoPath = trim(
            ($this->arguments[self::ARG_LOGOPATH] ?? '')
        );
        if ($logoPath !== '') {
            if (strpos($logoPath, WebhelpConf::KEY_STATIC_EXTENSIONPATH) === 0 || strpos($logoPath, '/') !== 0) {
                $logoPath = GeneralUtility::getFileAbsFileName($logoPath);
            }
            $logoPath = PathUtility::getAbsoluteWebPath($logoPath);

        }
        $attributes = [
            self::OUT_TEXT => json_encode(
                ($this->arguments[self::ARG_VALUE] ?? $this->renderChildren()),
                ENT_QUOTES
            ),
            self::OUT_LOGO => $logoPath,
        ];
        $this->tag->addAttributes($attributes);
        $this->tag->setContent('');
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }
}
