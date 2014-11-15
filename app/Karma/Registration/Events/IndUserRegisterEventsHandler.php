<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 08:23 PM
 */
namespace Karma\Registration\Events;



class IndUserRegisterEventsHandler {

    /**
     * @var IndUserRegisterEventsHandler
     */
    private $indUserRegisterEventsHandler;

    public function __construct(IndUserRegisterEventsHandler $indUserRegisterEventsHandler)
    {
        $this->indUserRegisterEventsHandler = $indUserRegisterEventsHandler;
    }


    /**
     * @param $data
     */
    public function onUserRegister($data)
    {
        $this->indUserRegisterEventsHandler->sendWelcomeEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('indUser.register', 'Karma\Registration\Events\IndUserRegisterEventsHandler@onUserRegister');
    }
}