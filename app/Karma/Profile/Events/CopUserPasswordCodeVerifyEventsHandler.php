<?php
/**
 * User: Prakash
 * Date: 9/30/14
 * Time: 09:04 AM
 */
namespace Karma\Profile\Events;


use Karma\Profile\Mailer\CopUserPasswordCodeVerify;

class CopUserPasswordCodeVerifyEventsHandler {

    /**
     * @var \Karma\Profile\Mailer\CopUserPasswordCodeVerify
     */
    private $copUserPasswordCodeVerify;

    /**
     * @param CopUserPasswordCodeVerify $copUserPasswordCodeVerify
     */
    function __construct(CopUserPasswordCodeVerify $copUserPasswordCodeVerify)
    {

        $this->copUserPasswordCodeVerify = $copUserPasswordCodeVerify;
    }

    /**
     * @param $data
     */
    public function onCodeVerify($data)
    {

        $this->copUserPasswordCodeVerify->sendEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('copUser.verifyCode', 'Karma\Profile\Events\CopUserPasswordCodeVerifyEventsHandler@onCodeVerify');
    }
}