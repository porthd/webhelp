<?php

namespace Porthd\Webhelp\Logger;


use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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
class MailsLogger implements SpecialLoggerInterface
{

    protected $mailTemplate = <<<MAILTEMPLATE
Unexpected happen in %s

Message:
========
%s

data (json):
============(begin)
%s
============(end)
MAILTEMPLATE;

    protected $toEmailList = [];
    protected $selfClass = __class__;
    protected $envConstName = 'TYPO3_MAIL_DEFAULTMAILFROMADDRESS';


    /**
     * @param string|string[] $mailList
     * @param string $envConstName
     */
    public function __construct($mailList = '', $mailTemplate= '', $envConstName='')
    {
        $flagDone = true;
        $this->envConstName = !empty(trim($envConstName))? trim($envConstName):$this->envConstName;
        $this->mailTemplate = !empty($mailTemplate)? $mailTemplate:$this->mailTemplate;
        if ((is_string($mailList)) &&
            (
                ($email = filter_var($mailList, FILTER_VALIDATE_EMAIL)) !== false
            )
        ) {
            $this->toEmailList = [$email];
        } else if (is_array($mailList)) {
            $flagDone = false;
            $this->toEmailList = [];
            foreach ($mailList ?? [] as $mailItem) {
                if ((is_string($mailItem)) &&
                    (
                        ($email = filter_var($mailItem, FILTER_VALIDATE_EMAIL)) !== false
                    )
                ) {
                    $flagDone = true;
                    $this->toEmailList[] = $email;
                }
            }
        }
        if (!$flagDone) {
            $this->toEmailList = [];
        }
    }

    /**
     * @param string $logLevel
     *
     * @return string
     */
    public function getStatus(string $logLevel = ''): string
    {
        if (!in_array($logLevel, SpecialLoggerInterface::LIST_LOG_LEVEL)) {
            return $logLevel;
        }
        return $logLevel;
    }


    /**
     * @param string $errorMessage
     * @param string $subject
     * @param string $status
     * @param string $jsonData
     * @return bool
     */
    public function addMessage(
        $errorMessage = '',
        $subject = '',
        $status = '',
        $jsonData = ''
    ): bool
    {
        if (empty($this->toEmailList)) {
            return false;
        }

        $fromEmail = (is_string(getenv($this->envConstName)) ?
            (string)getenv($this->envConstName) :
            ''
        );
        if (empty($fromEmail)) {
            return false;
        }

        $toList = array_filter(
            $this->toEmailList,
            function ($value) {
                return filter_var($value, FILTER_VALIDATE_EMAIL);
            }
        );
        if ((empty($toList)) || (empty($fromEmail))) {
            return false;
        }

        /** @var MailMessage $mail */
        $mail = GeneralUtility::makeInstance(MailMessage::class);
        // Prepare and send the message
        $mail->setFrom(array($fromEmail => $fromEmail));
        $mail->addTo(...$toList);

        // Give the message a subject
        if (empty($subject)) {
            $mail->setSubject(strtoupper($status) . ': Error in Command ' . $this->selfClass);
        } else {
            $mail->setSubject(strtoupper($status) . ':' . $subject . ' [' . $this->selfClass . ']');
        }

        // Give it the text message
        $mail->text(
            sprintf(
                $this->mailTemplate,
                $this->selfClass,
                $this->normalizeMyMessage($errorMessage),
                $jsonData
            )
        );
        // And finally send it
        $mail->send();
        return true;
    }

    /**
     * @param $errorMessage
     *
     * @return string
     */
    protected function normalizeMyMessage($errorMessage): string
    {
        if (empty($errorMessage)) {
            $myMessage = "The message is empty. Who knows, why?";
        } else if (is_string($errorMessage)) {
            $myMessage = $errorMessage;
        } else {
            $myMessage = "SHOULD NOT HAPPEN: The type of message is unknown. The ist the printed-part: \n" . print_r($errorMessage, true);
        }
        return $myMessage;
    }

}
