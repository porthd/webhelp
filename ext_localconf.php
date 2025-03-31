<?php

defined('TYPO3') || defined('TYPO3_MODE') || die('Access denied in ' . __FILE__ . '.');

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2020 Dr. Dieter Porthd <info@mobger.de>
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
    $extensionConfiguration = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Configuration\ExtensionConfiguration::class
    );
    $pageName = (string)$extensionConfiguration->get($extensionName, 'typoscriptPageName');
    $pageName = empty($pageName) ? 'page' : trim($pageName);
    foreach ([
                 'flagVCard' => 'WebcomponentVCard.js',
                 'flagICalendar' => 'WebcomponentICalendar.js',
                 'flagListSelectFilter' => 'WebcomponentListSelectFilter.js',
             ] as $webComponentId => $webComponentJsFile) {
        $flagComponent = (bool)$extensionConfiguration->get($extensionName, $webComponentId);

        if ($flagComponent) {
            $typoScript = $pageName . '.includeJSFooter.webhelp_' . $webComponentId .
                ' = EXT:webhelp/Resources/Public/JavaScript/' . $webComponentJsFile;
            \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
                $typoScript
            );
        }
    }
});
