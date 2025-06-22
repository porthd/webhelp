<?php

defined('TYPO3') || defined('TYPO3_MODE') || die('Access denied in ' . __FILE__ . '.');

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2025 Dr. Dieter Porthd <info@mobger.de>
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

call_user_func(function () {
    $extensionName = 'webhelp';
    $extensionConfiguration = GeneralUtility::makeInstance(
        ExtensionConfiguration::class
    );
    $pageName = (string)$extensionConfiguration->get($extensionName, 'typoscriptPageName');
    $pageName = empty($pageName) ? 'page' : trim($pageName);
    $path = trim(
        (string)$extensionConfiguration->get($extensionName, 'modulePathImportWebcomponents')
    );
    if (empty($path)) {
        $typoScript = '';
        foreach ([
                     'flagAjax' => 'WebcomponentAjax.js',
                     'flagBarchartFromTable' => 'WebcomponentBarchartFromTable.js',
                     'flagBreadcrumb' => 'WebcomponentBreadcrumb.js',
                     'flagCodeview' => 'WebcomponentCodeview.js',
                     'flagICalendar' => 'WebcomponentICalendar.js',
                     'flagInfomodal' => 'WebcomponentInfomodal.js',
                     'flagListSelectFilter' => 'WebcomponentListSelectFilter.js',
                     'flagTabNavi' => 'WebcomponentTabNavi.js.js',
                     'flagTimeZone' => 'WebcomponentTimeZone.js',
                     'flagTocGenerator' => 'WebcomponentTocGenerator.js',
                     'flagVCard' => 'WebcomponentVCard.js',
                 ] as $webComponentId => $webComponentJsFile) {
                $typoScript .= $pageName . '.includeJSFooter.webhelp_Single_import_' . $webComponentId .
                    ' = EXT:webhelp/Resources/Public/JavaScript/' . $webComponentJsFile ."\n";
        }
    } else {
        $typoScript = $pageName . '.includeJSFooter.webhelp_default_module_path_import = ' . $path;
        $typoScript = $typoScript . "\n" . $pageName . '.includeJSFooter.webhelp_default_module_path_import.type = module';
    }
    ExtensionManagementUtility::addTypoScriptSetup(
        $typoScript
    );
});
