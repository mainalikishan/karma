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

    function __construct(CopUserPasswordCodeVerify $copUserPasswordCodeVerify)
    {

        $this->copUserPasswordCodeVerify = $copUserPasswordCodeVerify;
    }

    public function onCodeVerify($data)
    {

        $this->copUserPasswordCodeVerify->sendEmail($data);
    }

    public function subscribe($events)
    {
        $events->listen('copUser.verifyCode', 'Karma\Profile\Events\CopUserPasswordCodeVerifyEventsHandler@onCodeVerify');
    }
}