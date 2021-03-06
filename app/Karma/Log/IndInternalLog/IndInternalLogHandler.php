<?php
/**
 * User: Prakash
 * Date: 10/12/14
 * Time: 8:41 PM
 */

namespace Karma\Log\IndInternalLog;


class IndInternalLogHandler {
    /**
     * @var IndInternalLog
     */
    private $indInternalLog;

    /**
     * @param IndInternalLog $indInternalLog
     */
    function __construct(IndInternalLog $indInternalLog)
    {
        $this->indInternalLog = $indInternalLog;
    }

    /**
     * @param $userId
     * @param bool $post
     */
    public static function addInternalLog($userId,$post=false)
    {
        $currentUrl = $uri = \ Request::url();
        $IP = \Request::getClientIp(true);
        $browser = \Agent::browser();
        $version = \Agent::version($browser);
        $platform = \Agent::platform();
        $versionPlatform = \Agent::version($platform);
        $logLoginAgent = $browser.",".$version.",".$platform.",".$versionPlatform;

        $details = json_encode(array('api_url'=>$currentUrl,'ip'=>$IP,'agent'=>$logLoginAgent,'post'=>$post));

        IndInternalLog::create(array(
            'logUserId' => $userId,
            'logDetails' => $details
        ));
    }

} 