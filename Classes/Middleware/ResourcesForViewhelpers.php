<?php

namespace Porthd\Webhelp\Middleware;

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


use Porthd\Webhelp\Config\WebhelpConf;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;

/**
 * Class ResourcesForFrontendEditing
 * This extension add some needed styles and javascript-codes to the rendered page
 */
class ResourcesForViewhelpers implements MiddlewareInterface
{
    protected const EXT_CONF_FLAG_ALLOW_ALWAYS = 'flagAllowAlways';

    protected const EXT_CONF_USE_LIB_JS = 'useLibJs';
    protected const EXT_CONF_USE_FOOTER_LIB_JS = 'useFooterLibJs';
    protected const EXT_CONF_USE_STYLE = 'useStyle';

    protected const EXT_CONF_LIST_RESOURCEPATH_MIN = [
        self::EXT_CONF_USE_STYLE,
        self::EXT_CONF_USE_LIB_JS,
        self::EXT_CONF_USE_FOOTER_LIB_JS,
    ];

    /** @var PageRenderer */
    protected $pageRender;

    protected $flags = [
        'compress' => true,
        'exclude' => true,
    ];

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $extensionConfig = GeneralUtility::makeInstance(ExtensionConfiguration::class)
            ->get(WebhelpConf::SELF_NAME);

        if (!empty($extensionConfig[self::EXT_CONF_FLAG_ALLOW_ALWAYS])) {
            $this->adaptForDevelopmentContext($extensionConfig);
            /** @var array $editorList */

            $this->pageRender = GeneralUtility::makeInstance(PageRenderer::class);
            $this->addBasicFooterJavascript($extensionConfig); //
            $this->addBasicStylesheet($extensionConfig);

        }
        return $handler->handle($request);
    }

    /**
     * @param array $extensionConfig
     */
    protected function addBasicFooterJavascript(array $extensionConfig): void
    {
        foreach ([
                     self::EXT_CONF_USE_LIB_JS => 'addJsFile',
                     self::EXT_CONF_USE_FOOTER_LIB_JS => 'addJsFooterFile',
                 ] as $key => $addJsMethod
        ) {
            if (!empty($extensionConfig[$key])) {
                $list = array_filter(
                    array_map(
                        'trim',
                        explode(',', $extensionConfig[$key])
                    )
                );
                foreach ($list as $item) {
                    if (strpos($item, WebhelpConf::KEY_STATIC_EXTENSIONPATH) === 0 || strpos($item, '/') !== 0) {
                        $source = GeneralUtility::getFileAbsFileName($item);
                    }
                    $source = PathUtility::getAbsoluteWebPath($source);
                    // both method `addJsFile`, `addJsFooterFile` have the same argument-structure
                    $this->pageRender->$addJsMethod(
                        $source,
                        'text/javascript', $this->flags['compress'], true,
                        '', $this->flags['exclude'], true
                    );
                }
            }
        }
    }

    /**
     * @param array $extensionConfig
     */
    protected function addBasicStylesheet(array $extensionConfig): void
    {
        if (!empty($extensionConfig[self::EXT_CONF_USE_STYLE])) {
            $list = array_filter(
                array_map(
                    'trim',
                    explode(',', $extensionConfig[self::EXT_CONF_USE_STYLE])
                )
            );
            foreach ($list as $item) {
                if (strpos($item, WebhelpConf::KEY_STATIC_EXTENSIONPATH) === 0 || strpos($item, '/') !== 0) {
                    $source = GeneralUtility::getFileAbsFileName($item);
                }
                $source = PathUtility::getAbsoluteWebPath($source);
                $this->pageRender->addCssLibrary(
                    $source,
                    'stylesheet', '', '', $this->flags['compress'], false,
                    '', $this->flags['exclude']);
            }
        }
    }

    /**
     * only needed for testing-aspects. This is an affront against clean-code-principles,
     * because this code is never needed in the production.
     * remark: the comma-separated lists  are stored in `typo3conf\LocalConfiguration.php`.
     * There is no easy way to remove that cache-like infos. And a manually change will cause mistake in the continous deployment.
     *
     * @param array &$extensionConfig
     */
    protected function adaptForDevelopmentContext(array &$extensionConfig): void
    {
        if (strpos(strtolower(Environment::getContext()), WebhelpConf::TYPO3_CONTEXT_DEVELOPMENT) === 0) {
            $this->flags = [
                'compress' => false,
                'exclude' => true,
            ];
            // use the normal versions instead of the minified version, detectable by `.min.`-fragment
            foreach (self::EXT_CONF_LIST_RESOURCEPATH_MIN as $commaListKey) {
                if (!empty($extensionConfig[$commaListKey])) {
                    $extensionConfig[$commaListKey] = implode(
                        '.',
                        explode('.min.', $extensionConfig[$commaListKey])
                    );
                }
            }
        }
    }
}
