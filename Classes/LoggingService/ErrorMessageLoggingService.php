<?php

namespace Porthd\Webhelp\LoggingService;


use Porthd\Webhelp\Logger\SpecialLoggerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Psr\Log\LogLevel;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Scheduler\Scheduler;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2021 Dr. Dieter Porth <info@mobger.de> TYPO3-developer
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
class ErrorMessageLoggingService implements SingletonInterface
{


    public const FLAG_BIT_SET_DEFAULT = self::FLAG_BIT_SET_SCHEDULER | self::FLAG_BIT_SET_SYMFONY_IO_LOG | self::FLAG_BIT_SET_T3_BACKEND_FLASH | self::FLAG_BIT_SET_FLASHER;
    public const FLAG_BIT_SET_SPECIALLOGGER = 1;
    public const FLAG_BIT_SET_SCHEDULER = 2;
    public const FLAG_BIT_SET_SYMFONY_IO_LOG = 4;
    public const FLAG_BIT_SET_T3_BACKEND_FLASH = 8;
    public const FLAG_BIT_SET_FLASHER = 16;

    public const FLAG_BIT_RECIEVER_ERROR = self::FLAG_BIT_RECIEVER_DEVELOPER | self::FLAG_BIT_RECIEVER_ADMIN;
    public const FLAG_BIT_RECIEVER_ALL = self::FLAG_BIT_RECIEVER_DEVELOPER | self::FLAG_BIT_RECIEVER_USER | self::FLAG_BIT_RECIEVER_ADMIN;
    public const FLAG_BIT_RECIEVER_USERADMIN = self::FLAG_BIT_RECIEVER_USER | self::FLAG_BIT_RECIEVER_ADMIN;
    public const FLAG_BIT_RECIEVER_DEVELOPER = 1;
    public const FLAG_BIT_RECIEVER_USER = 2;
    public const FLAG_BIT_RECIEVER_ADMIN = 4;

    protected const CODE_LENGTH_MAX = 20;
    protected const SUBJECT_LENGTH_MAX = 100;
    const REMARK_RECIEVER = 'reciever';
    const REMARK_FLAG = 'flag';
    const REMARK_MAP = 'map';
    const REMARK_ERRORTYPE = 'errorType';
    const REMARK_JSON_DATA = 'data';
    const REMARK_SUBJECT = 'subject';
    const REMARK_CODE = 'code';
    const REMARK_MESSAGE = 'message';
    const MARKFLAG_USE_LOG = 'useLog';
    const MARKMAP_FUNCTION_NAME_LOGGING = 'functionNameLogging';
    const MARKMAP_FUNCTION_NAME_LOG = 'functionNameLog';
    const MARKFLAG_USE_SCHEDULER = 'useScheduler';
    const MARK_MAP_SCHEDULER_STAT = 'schedulerStat';
    const MARKFLAG_USE_LOGGING = 'useLogging';
    const MARKMAP_FLASH_STATUS = 'flashStatus';
    const MARKFLAG_USE_SPECIAL_LOGGER = 'useSpecialLogger';
    const CODE_DEFAULT = "xxx-9876543210";

    use LoggerAwareTrait;

    protected $languageKey = 'en'; // 'de'??


    protected $listSchedulerStats = [
        LogLevel::EMERGENCY => 3,
        LogLevel::ALERT => 1,
        LogLevel::CRITICAL => 2,
        LogLevel::ERROR => 2,
        LogLevel::WARNING => 0,
        LogLevel::NOTICE => 0,
        LogLevel::INFO => 0,
        LogLevel::DEBUG => 0,
    ];

    /**
     * @var int
     */
    protected $reciever = 0;

    /**
     * @var array
     */
    protected $list = [];

    /**
     * Reference to a symfony-log-object, which will defined
     *
     * @var SymfonyStyle
     */
    protected $log;

    /**
     * Reference to a symfony-log-object, which will defined
     *
     * @var LoggerInterface
     */
    protected $logging;

    /**
     * Reference to a scheduler object
     *
     * @var \TYPO3\CMS\Scheduler\Scheduler
     */
    protected $scheduler;

    /**
     * Reference to a scheduler object
     *
     * @var FlashMessageService
     */
    protected $flasher;

    /**
     * list of classes for special logger
     *
     * @var array
     */
    protected $specialLogger = [];


    /**
     * @param int                      $flagSet
     * @param string                   $name
     * @param array                    $specialLogger
     * @param Scheduler|null           $scheduler
     * @param InputInterface|null      $input
     * @param OutputInterface|null     $output
     * @param FlashMessageService|null $flasher
     */
    public function __construct(
        int                  $flagSet = self::FLAG_BIT_SET_DEFAULT,
        string               $name = '',
        array                $specialLogger = [],
        ?Scheduler           $scheduler = null,
        ?InputInterface      $input = null,
        ?OutputInterface     $output = null,
        ?FlashMessageService $flasher = null
    )
    {
        $this->constructErrorMessageLater(
            $flagSet,
            $name,
            $specialLogger,
            $scheduler,
            $input,
            $output,
            $flasher
        );
    }

    /**
     * constructErrorMessageTraitName constructor.
     *
     * @param SymfonyStyle|null $log
     */
    public function constructErrorMessageTraitName(
        string $name = ''
    )
    {
        if ((!empty($name)) && is_string($name)) {
            $this->name = $name;
        }
    }

    /**
     * constructErrorMessageTraitLog constructor.
     *
     * @param InputInterface|null  $input
     * @param OutputInterface|null $output
     */
    public function constructErrorMessageTraitLog(
        ?InputInterface $input = null, ?OutputInterface $output = null
    )
    {
        if (($input !== null) && ($output !== null)) {
            $this->log = new SymfonyStyle($input, $output);
        }
    }

    /**
     * constructErrorMessageTraitScheduler constructor.
     *
     * @param Scheduler|null $scheduler
     */
    public function constructErrorMessageTraitScheduler(
        ?Scheduler $scheduler = null
    )
    {
        $this->scheduler = $scheduler ?? null;
    }

    /**
     * constructErrorMessageTraitFlasher constructor.
     *
     * @param FlashMessageService|null $flasher
     */
    public function constructErrorMessageTraitFlasher($flasher = null)
    {
        $context = GeneralUtility::makeInstance(Context::class);
        if ($context->getPropertyFromAspect('backend.user', 'isLoggedIn')) {
            $this->flasher = $flasher ?? GeneralUtility::makeInstance(FlashMessageService::class);
        }
    }

    /**
     * constructErrorMessageTraitSpecialLogger constructor.
     *
     * @param array $specialLogger
     */
    public function constructErrorMessageTraitSpecialLogger($specialLogger = [])
    {
        if (!empty($specialLogger)) {

            $specialLoggerInterface = SpecialLoggerInterface::SELF_CLASS_NAME;
            foreach ($specialLogger as $className) {
                if ((is_string($className)) &&
                    (($list = class_implements($className)) !== false) &&
                    (in_array($specialLoggerInterface, $list))
                ) {
                    $this->specialLogger[] = new $className();
                } else if ((is_string($className['class'])) &&
                    (is_array($className['params'])) &&
                    (($myList = class_implements($className['class'])) !== false) &&
                    (in_array($specialLoggerInterface, $myList))
                ) {
                    $myClassName = $className['class'];
                    $myParams = $className['params'];
                    $this->specialLogger[] = new  $myClassName(...$myParams);
                }
            }
        }
    }

    /**
     * @param int                      $flagSet
     * @param string                   $name
     * @param array                    $specialLogger // List of Strings oder Array(class=> String, params=> array)
     * @param Scheduler|null           $scheduler
     * @param InputInterface|null      $input
     * @param OutputInterface|null     $output
     * @param FlashMessageService|null $flasher
     */
    public function constructErrorMessageLater(
        int                  $flagSet = self::FLAG_BIT_SET_DEFAULT,
        string               $name = '',
        array                $specialLogger = [],
        ?Scheduler           $scheduler = null,
        ?InputInterface      $input = null,
        ?OutputInterface     $output = null,
        ?FlashMessageService $flasher = null
    )
    {

        if ($flagSet & self::FLAG_BIT_SET_SPECIALLOGGER) {  // BITWeise
            $this->constructErrorMessageTraitName($name);
        }
        if ($flagSet & self::FLAG_BIT_SET_SCHEDULER) { // BITWeise
            $this->constructErrorMessageTraitScheduler($scheduler);
        }
        if ($flagSet & self::FLAG_BIT_SET_SYMFONY_IO_LOG) { // BITWeise
            $this->constructErrorMessageTraitLog($input, $output);
        }
        if ($flagSet & self::FLAG_BIT_SET_T3_BACKEND_FLASH) { // BITWeise
            $this->constructErrorMessageTraitFlasher($flasher);
        }
        if ($flagSet & self::FLAG_BIT_SET_FLASHER) { // BITWeise
            $this->constructErrorMessageTraitSpecialLogger($specialLogger);
        }
    }

    /**
     * register some message for feedback, exception oder logging
     *
     * @param string $errorType // must be Type of LogLevel
     * @param int    $reciever // which messages should be respected
     * @param string $errorMessage should not contain some datas
     * @param string $code should be shorter than 20 chars
     * @param string $subject should be shorter than hundred chars
     * @param array  $data should be an array
     * @param string $throwExceptionClass if not empty and if the classname is defined, it would try to throw the defined exception (otherwise in case of undefined, not empty classname a normal exception will be thrown.).
     *
     * @throws \Exception
     */
    public function addErrorMessage(
        string $errorType,
        int    $reciever,
        string $errorMessage,
        string $code = self::CODE_DEFAULT,
        string $subject = '',
               $data = [],
               $throwExceptionClass = ''
    )
    {
        $myRemark = [];
        $myRemark[self::REMARK_MESSAGE] = $this->normalizeMyMessage($errorMessage);
        $myRemark[self::REMARK_CODE] = $this->normalizeMyCode($code);
        $myRemark[self::REMARK_SUBJECT] = $this->normalizeMySubject($subject);
        $myRemark[self::REMARK_JSON_DATA] = json_encode($data);
        $flag = $this->predefineFlags();

        list($map, $flag) = $this->refineMapFromErrorType($errorType, $flag);
        $myRemark[self::REMARK_ERRORTYPE] = $errorType;
        $myRemark[self::REMARK_MAP] = $map;
        $myRemark[self::REMARK_FLAG] = $flag;
        $myRemark[self::REMARK_RECIEVER] = $reciever;

        $this->list[] = $myRemark;
        if (!empty($throwExceptionClass)) {
            if (class_exists($throwExceptionClass)) {
                throw new $throwExceptionClass(
                    'Throw my exception. Please see my defined channels for more reasoning.',
                    1639738623
                );
            } else {
                $this->setReciever(self::FLAG_BIT_RECIEVER_ALL);
                throw new \Exception('Definition of Exception failed. The defined exception-class `' .
                    $throwExceptionClass . '` is unkown.',
                    1639738621
                );
            }
        }
    }

    /**
     * @param false $flagDebug // show infos to debug-channel
     */
    public function finalPropagateMessage($flagDebug = false)
    {
        if (!empty($this->list)) {
            foreach ($this->list as $item) {
                if (($flagDebug) ||
                    ($this->isReciever($item[self::REMARK_RECIEVER]))
                ) {
                    $flag = $item[self::REMARK_FLAG];
                    $map = $item[self::REMARK_MAP];
                    if (($this->log !== null) &&
                        ($flag[self::MARKFLAG_USE_LOG])
                    ) {
                        $functionNameLog = $map[self::MARKMAP_FUNCTION_NAME_LOG];
                        $this->log->$functionNameLog(
                            $item[self::REMARK_MESSAGE]
                        );
                    }
                    if (($this->scheduler !== null) &&
                        ($flag[self::MARKFLAG_USE_SCHEDULER])
                    ) {
                        $this->scheduler->log(
                            $item[self::REMARK_MESSAGE],
                            $map[self::MARK_MAP_SCHEDULER_STAT],
                            $item[self::REMARK_CODE]
                        );
                    }
                    if (($this->logging !== null) &&
                        ($flag[self::MARKFLAG_USE_LOGGING])
                    ) {
                        $functionNameLogging = $map[self::MARKMAP_FUNCTION_NAME_LOGGING];
                        $this->logging->$functionNameLogging(
                            $item[self::REMARK_MESSAGE],
                            $item[self::REMARK_JSON_DATA]
                        ); // $a´´ata is array
                    }
                    if (($this->flasher !== null) &&
                        ($flag['useFlasher'])
                    ) {
                        /** @var FlashMessageQueue $flashIdent */
                        $flashQueue = $this->flasher->getMessageQueueByIdentifier();
                        $flashMessage = new FlashMessage(
                            $item[self::REMARK_MESSAGE],
                            $item[self::REMARK_SUBJECT],
                            $map[self::MARKMAP_FLASH_STATUS],
                            true
                        );
                        $flashQueue->addMessage($flashMessage);
                    }
                    if ($flag[self::MARKFLAG_USE_SPECIAL_LOGGER]) {

                        foreach ($this->specialLogger as $specialLogObject) {
                            $customStatus = $specialLogObject->getStatus($item[self::REMARK_ERRORTYPE]);
                            $specialLogObject->addMessage(
                                $item[self::REMARK_MESSAGE],
                                $item[self::REMARK_SUBJECT],
                                $customStatus,
                                $map[self::REMARK_JSON_DATA],
                            );
                        }
                    }

                }
            }
        }

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
            if (strpos($errorMessage, 'LLL:') === 0) {
                $myMessage = LocalizationUtility::translate(
                    $errorMessage, null, null, $this->languageKey
                );
                // prevent the case, that the language-file ist
                $myMessage = $myMessage??"SHOULD NOT HAPPEN: Perhaps you must clear the system-cache in TYPO3 (ref-thunder).";
            } else {
                $myMessage = $errorMessage;
            }
        } else {
            $myMessage = "SHOULD NOT: The type of message is unknown. The is the printed-part: \n" .
                print_r($errorMessage, true);
        }
        return $myMessage;
    }

    /**
     * @param $errorMessage
     *
     * @return string
     */
    protected function normalizeMyCode(string $code): string
    {
        if (empty($code)) {
            $myCode = self::CODE_DEFAULT;
        } else if (mb_strlen($code) > self::CODE_LENGTH_MAX) {
            $myCode = mb_substr($code, 0, self::CODE_LENGTH_MAX - 1) . '...';
        } else {
            $myCode = $code;
        }
        return $myCode;
    }

    /**
     * @param $errorMessage
     *
     * @return string
     */
    protected function normalizeMySubject(string $subject): string
    {
        $mySubject = "--- undefinde subject ---";
        if (!empty($subject)) {
            if (strpos($subject, 'LLL:') === 0) {
                $mySubject = LocalizationUtility::translate(
                    $subject, null, null, $this->languageKey
                );
                $mySubject = $mySubject??"--- undefinde subject ---";
            } else if (mb_strlen($subject) < self::SUBJECT_LENGTH_MAX) {
                $mySubject = mb_substr($subject, 0, self::SUBJECT_LENGTH_MAX);
            } else {
                $mySubject = $subject;
            }
        }
        return $mySubject;
    }

    /**
     * @return array
     */
    protected function predefineFlags(): array
    {
        $flag[self::MARKFLAG_USE_LOG] = true;
        $flag[self::MARKFLAG_USE_SCHEDULER] = true;
        $flag[self::MARKFLAG_USE_LOGGING] = true;
        $flag['useFlasher'] = true;
        $flag[self::MARKFLAG_USE_SPECIAL_LOGGER] = (!empty($this->specialLogger));
        $flag['throwException'] = false;
        return $flag;
    }

    /**
     * @param string $errorType
     * @param array  $flag
     *
     * @return array[]
     */
    protected function refineMapFromErrorType(string $errorType, array $flag): array
    {
        switch ($errorType) {
            case LogLevel::EMERGENCY :
                $map['functionNamelog'] = 'error';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::EMERGENCY];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'emergency';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::ERROR;
                break;
            case LogLevel::ALERT     :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'error';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::ALERT];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'alert';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::ERROR;
                break;
            case LogLevel::CRITICAL  :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'error';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::CRITICAL];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'critical';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::ERROR;
                break;
            case LogLevel::ERROR     :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'error';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::ERROR];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'error';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::ERROR;
                break;
            case LogLevel::WARNING   :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'warning';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::WARNING];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'warning';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::WARNING;
                break;
            case LogLevel::NOTICE    :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'note';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::NOTICE];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'notice';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::NOTICE;
                break;
            case LogLevel::INFO      :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'note';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::INFO];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'info';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::INFO;
                break;
            case LogLevel::DEBUG     :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'comment';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::DEBUG];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'debug';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::INFO;

                break;
            default :
                $map[self::MARKMAP_FUNCTION_NAME_LOG] = 'comment';
                $map[self::MARK_MAP_SCHEDULER_STAT] = $this->listSchedulerStats[LogLevel::INFO];
                $map[self::MARKMAP_FUNCTION_NAME_LOGGING] = 'log';
                $map[self::MARKMAP_FLASH_STATUS] = FlashMessage::INFO;

                $flag[self::MARKFLAG_USE_LOG] = true;
                $flag[self::MARKFLAG_USE_SCHEDULER] = true;
                $flag[self::MARKFLAG_USE_LOGGING] = true;
                $flag['useFlasher'] = false;
                $flag['throwException'] = true;
                break;
        }
        return [$map, $flag];
    }


    /**
     * @return int get current reciever-notations
     */
    public function getReciever(): int
    {
        return $this->reciever;
    }

    /**
     * @param int $reciever positive integer
     */
    public function addReciever(int $reciever): void
    {
        $this->reciever = $this->reciever | abs($reciever);
    }

    /**
     * @param int $reciever positive integer
     */
    public function setReciever(int $reciever): void
    {
        $this->reciever = abs($reciever);
    }

    /**
     * @return bool check against positiv integer
     */
    public function isReciever(int $reciever): bool
    {
        return (($this->reciever & abs($reciever)) === abs($reciever));
    }

    /**
     * @return string
     */
    public function getLanguageKey(): string
    {
        return $this->languageKey;
    }

    /**
     * @param string $languageKey
     */
    public function setLanguageKey(string $languageKey): void
    {
        $this->languageKey = $languageKey;
    }
}
