<?php

namespace Porthd\Webhelp\Config;

use PDO;
use Porthd\Simpledataedit\Editor\Interfaces\CustomEditorInterface;

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
 * Class for extension-wide constants. I dislike text in programm-code.
 *
 */
class WebhelpConf
{
    public const SELF_NAME = 'webhelp';

    public const KEY_STATIC_EXTENSIONPATH = 'EXT:';
    public const TYPO3_CONTEXT_DEVELOPMENT = 'development';
}
