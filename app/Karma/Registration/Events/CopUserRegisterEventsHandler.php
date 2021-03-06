<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 11:47 AM
 */
namespace Karma\Registration\Events;


use Karma\Registration\Mailer\CopCustomRegister;
use Karma\Registration\Mailer\CopLinkedInRegister;

class CopUserRegisterEventsHandler {

    /**
     * @var \Karma\Registration\Mailer\CopCustomRegister
     */
    private $copCustomRegister;
    /**
     * @var \Karma\Registration\Mailer\CopLinkedInRegister
     */
    private $copLinkedInRegister;

    /**
     * @param CopCustomRegister $copCustomRegister
     * @param CopLinkedInRegister $copLinkedInRegister
     */
    function __construct(CopCustomRegister $copCustomRegister,
                         CopLinkedInRegister $copLinkedInRegister)
    {
        $this->copCustomRegister = $copCustomRegister;
        $this->copLinkedInRegister = $copLinkedInRegister;
    }

    /**
     * @param $data
     */
    public function onUserRegister($data)
    {
        $userOauthType = $data->userOauthType;
        $this->$userOauthType->sendWelcomeEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('copUser.register', 'Karma\Registration\Events\CopUserRegisterEventsHandler@onUserRegister');
    }
}