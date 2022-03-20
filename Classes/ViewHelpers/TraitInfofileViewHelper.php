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
 */

use Porthd\Webhelp\Config\WebhelpConf;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

trait TraitInfofileViewHelper
{


    protected function normalizeFileName($fileName = self::DEFAULT_FILE_NAME) {
        $list = [
            'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue', 'ß' => 'ss',
            'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue',
            'á' => 'a','â' => 'a','à' => 'a',
            'é' => 'e','ê' => 'e','è' => 'e',
            'í' => 'i','î' => 'i','ì' => 'i',
            'ó' => 'o','ô' => 'o','ò' => 'o',
            'ú' => 'u','û' => 'u','ù' => 'u',
        ];

        $search = array_keys($list );
        $replace = array_values($list );
        $result = str_replace($search,$replace, $fileName);
        return preg_replace("/[^A-Za-z0-9-_]/", '_', $result);

    }

    /**
     * @param array $argList
     * @param string $jsonString
     * @param $fluidData
     * @param array $arguments
     * @return array
     */
    protected function mergeDataFromThreeSources(array &$arguments, array $argList, $fluidData=null, string $jsonString='' ): array
    {

        $flagJson = false;
        if (!empty($jsonString)) {
            $jsonList = json_decode($jsonString, true);
            if (!is_array($jsonList)) {
                $jsonList = [];
            } else {
                $flagJson = true;
            }
        }
        $fluidObj = null;
        $fluidList = [];
        if ($fluidData !== null) {
            if (is_object($fluidData)) {
                $fluidObj = $fluidData;
                $flagFluidObj = (is_object($fluidObj));
                $flagFluidList = false;
            } else {
                $flagFluidObj = false;
                $fluidList = $fluidData;
                $flagFluidList = (!empty($fluidList)) && is_array($fluidList);
            }
        }
        $data = [];
        foreach ($argList as $name => $info) {

            $getter = 'get' . ucfirst($name);
            $data[$name] = $arguments[$name] ?? '';
            if (($flagJson) &&
                (isset($jsonList[$name]))
            ) {
                $data[$name] = $jsonList[$name];
            }
            if (($flagFluidList) &&
                (isset($fluidList[$name]))
            ) {
                $data[$name] = $fluidList[$name];
            }
            if (($flagFluidObj) &&
                (method_exists($fluidObj, $getter))
            ) {
                $data[$name] = $fluidObj->$getter();
            }
        }
        return $data;
    }


}
