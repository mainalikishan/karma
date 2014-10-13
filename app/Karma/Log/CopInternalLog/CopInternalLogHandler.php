<?php
/**
 * User: Prakash
 * Date: 10/12/14
 * Time: 8:03 PM
 */

namespace Karma\Log\CopInternalLog;


class CopInternalLogHandler {
    /**
     * @var CopInternalLog
     */
    private $copInternalLog;

    function __construct(CopInternalLog $copInternalLog)
    {
        $this->copInternalLog = $copInternalLog;
    }

    public static function addInternalLog($userId,$post=false)
    {


        $currentUrl = $uri = \ Request::url();;
        $IP = \Request::getClientIp(true);
        $browser = \Agent::browser();
        $version = \Agent::version($browser);
        $platform = \Agent::platform();
        $versionPlatform = \Agent::version($platform);
        $logLoginAgent = $browser.",".$version.",".$platform.",".$versionPlatform;


        $details = json_encode(array('api_url'=>$currentUrl,'ip'=>$IP,'agent'=>$logLoginAgent,'post'=>$post));

        CopInternalLog::create(array(
            'logUserId' => $userId,
            'logDetails' => $details
        ));
    }

} 