<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 9:06 PM
 */

namespace Karma\Hire\Events;


use Karma\Hire\Mailer\IndHireMailer;

class IndHireEventsHandler {

    /**
     * @var \Karma\Hire\Mailer\IndHireMailer
     */
    private $indHireMailer;

    public function __construct(IndHireMailer $indHireMailer)
    {
        $this->indHireMailer = $indHireMailer;
    }


    /**
     * @param $data
     */
    public function onHire($data)
    {
        $this->indHireMailer->sendEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('indUser.hire', 'Karma\Hire\Events\IndHireEventsHandler@onHire');
    }

} 