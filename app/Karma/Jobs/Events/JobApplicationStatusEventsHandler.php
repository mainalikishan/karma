<?php
/**
 * User: Prakash
 * Date: 11/9/14
 * Time: 7:31 AM
 */

namespace Karma\Jobs\Events;


use Karma\Jobs\Mailer\JobApplicationStatusMailer;

class JobApplicationStatusEventsHandler
{
    /**
     * @var \Karma\Jobs\Mailer\JobApplicationStatusMailer
     */
    private $jobApplicationStatusMailer;

    public function __construct(JobApplicationStatusMailer $jobApplicationStatusMailer)
    {
        $this->jobApplicationStatusMailer = $jobApplicationStatusMailer;
    }


    /**
     * @param $data
     */
    public function onApplicationStatusChange($data)
    {
        $this->jobApplicationStatusMailer->sendEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('application.changeStatus',
            'Karma\Jobs\Events\JobApplicationStatusEventsHandler@onApplicationStatusChange');
    }

} 