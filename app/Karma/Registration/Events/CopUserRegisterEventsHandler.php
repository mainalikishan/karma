<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 11:47 AM
 */
namespace Karma\Registration\Events;
use Karma\Registration\Mailer\CopUserRegisterMailer;

class CopUserRegisterEventsHandler {
    /**
     * @var \Karma\Registration\Mailer\CopUserRegisterMailer
     */
    private $copUserRegisterMailer;

    function __construct(CopUserRegisterMailer $copUserRegisterMailer)
    {
        $this->copUserRegisterMailer = $copUserRegisterMailer;
    }

    /**
     * Handle user register events.
     */

    public function onUserRegister($event)
    {
        $this->copUserRegisterMailer->sendWelcomeEmail($event);
    }

    public function subscribe($events)
    {
        $events->listen('copUser.register', 'Karma\Registration\Events\CopUserRegisterEventsHandler@onUserRegister');
    }

}