<?php
/**
 * User: Prakash
 * Date: 10/12/14
 * Time: 8:03 PM
 */

namespace Karma\Log\CopActivityLog;

class CopActivityLogHandler
{
    /**
     * @var CopInternalLog
     */
    private $copActivityLog;

    /**
     * @param CopActivityLog $copActivityLog
     */
    function __construct(CopActivityLog $copActivityLog)
    {
        $this->copActivityLog = $copActivityLog;
    }

    /**
     * @param $userId
     * @param $logText
     */
    public static function addActivityLog($userId, $logText)
    {
        CopActivityLog::create(array(
            'logUserId' => $userId,
            'logDetails' => $logText
        ));
    }

} 