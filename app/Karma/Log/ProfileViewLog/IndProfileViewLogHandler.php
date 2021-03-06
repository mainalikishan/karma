<?php
/**
 * User: Prakash
 * Date: 11/03/14
 * Time: 9:21 PM
 */

namespace Karma\Log\ProfileViewLog;


use Carbon\Carbon;

class IndProfileViewLogHandler
{

    /**
     * @var \Karma\Log\ProfileViewLog\IndProfileViewLogHandler
     */
    private $indProfileViewLog;

    /**
     * @param IndProfileViewLog $indProfileViewLog
     */
    function __construct(IndProfileViewLog $indProfileViewLog)
    {

        $this->indProfileViewLog = $indProfileViewLog;
    }

    /**
     * @param $logViewerId
     * @param $logUserId
     * @param $logUserType
     */
    public static function addProfileViewLog($logViewerId, $logUserId, $logUserType)
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