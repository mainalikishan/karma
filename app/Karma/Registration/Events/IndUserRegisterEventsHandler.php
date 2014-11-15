<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 08:23 PM
 */
namespace Karma\Registration\Events;



use Karma\Registration\Mailer\IndRegisterMailer;

class IndUserRegisterEventsHandler {

    /**
     * @var \Karma\Registration\Mailer\IndRegisterMailer
     */
    private $indRegisterMailer;

    public function __construct(IndRegisterMailer $indRegisterMailer)
    {
        $this->indRegisterMailer = $indRegisterMailer;
    }

    /**
     * @param $data
     */
    public function onUserRegister($data)
    {
       $this->indRegisterMailer->sendWelcomeEmail($data);

    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('indUser.register', 'Karma\Registration\Events\IndUserRegisterEventsHandler@onUserRegister');
    }
}