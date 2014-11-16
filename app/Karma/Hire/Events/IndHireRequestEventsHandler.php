<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 9:06 PM
 */

namespace Karma\Hire\Events;


use Karma\Hire\Mailer\IndHireRequestMailer;

class IndHireRequestEventsHandler {

    /**
     * @var \Karma\Hire\Mailer\IndHireRequestMailer
     */
    private $indHireRequestMailer;

    public function __construct(IndHireRequestMailer $indHireRequestMailer)
    {
        $this->indHireRequestMailer = $indHireRequestMailer;
    }


    /**
     * @param $data
     */
    public function onHire($data)
    {
        $this->indHireRequestMailer->sendEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('indUser.hireRequest', 'Karma\Hire\Events\IndHireRequestEventsHandler@onHire');
    }

}