<?php
/**
 * User: Prakash
 * Date: 10/13/14
 * Time: 8:45 PM
 */

namespace Karma\Log\IndActivityLog;

class IndActivityLogHandler
{
    /**
     * @var IndInternalLog
     */
    private $indActivityLog;

    /**
     * @param IndActivityLog $indActivityLog
     */
    function __construct(IndActivityLog $indActivityLog)
    {
        $this->indActivityLog = $indActivityLog;
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