<?php
/**
 * User: Prakash
 * Date: 11/03/14
 * Time: 8:41 PM
 */

namespace Karma\Log\ProfileViewLog;


use Carbon\Carbon;

class CopProfileViewLogHandler {

    /**
     * @var \Karma\Log\ProfileViewLog\CopProfileViewLog
     */
    private $copProfileViewLog;

    /**
     * @param CopProfileViewLog $copProfileViewLog
     */
    function __construct(CopProfileViewLog $copProfileViewLog)
    {

        $this->copProfileViewLog = $copProfileViewLog;
    }

    /**
     * @param $logViewerId
     * @param $logUserId
     * @param $logUserType
     */
    public static function addProfileViewLog($logViewerId,$logUserId,$logUserType)
    {
        CopProfileViewLog::create(array(
            'logViewerId' => $logViewerId,
            'logUserId' => $logUserId,
            'logUserType' => $logUserType,
            'logAddedDate' => Carbon::now(),
            'logUpdatedDate' => Carbon::now()
        ));
    }

} 