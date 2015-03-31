<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 9:06 PM
 */

namespace Karma\Hire\Events;


use Karma\Hire\Mailer\IndHireAcceptMailer;

class IndHireAcceptEventsHandler {

    /**
     * @var \Karma\Hire\Mailer\IndHireRequestMailer
     */
    private $indHireAcceptMailer;

    public function __construct(IndHireAcceptMailer $indHireAcceptMailer)
    {
        $this->indHireAcceptMailer = $indHireAcceptMailer;
    }


    /**
     * @param $data
     */
    public function onAccept($data)
    {
        $this->indHireAcceptMailer->sendEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('indUser.hireAccept', 'Karma\Hire\Events\IndHireAcceptEventsHandler@onAccept');
    }

}