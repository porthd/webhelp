<?php

namespace Porthd\Webhelp\Logger;


use Psr\Log\LogLevel;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de>
 *
 *  All rights reserved
 *
 *  This script is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
interface SpecialLoggerInterface
{
    public const SELF_NAME = 'SpecialLoggerInterface';

    public const SELF_CLASS_NAME = 'Monsun\\Matthaeisite\\Logger\\' . self::SELF_NAME;

    public const LIST_LOG_LEVEL = [
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::CRITICAL,
        LogLevel::ALERT,
        LogLevel::EMERGENCY,
    ];

    /**
     * @param string|null $loglevel
     *
     * @return string
     */
    public function getStatus(string $loglevel = ''): string;

    /**
     * @param string $errorMessage
     * @param string $subject
     * @param string $status
     * @param string $data
     *
     * @return bool     Returns true, if the custom stuff worke. Returns false, if the custom stuff failed for any reason
     */
    public function addMessage($errorMessage = '',
                               $subject = '',
                               $status = '',
                               $jsonData = ''
    ): bool;
}
