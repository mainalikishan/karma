<?php
/**
 * User: Prakash
 * Date: 10/30/14
 * Time: 7:31 AM
 */

namespace Karma\Jobs\Events;


use Karma\Jobs\Mailer\JobApplyMailer;

class JobApplyEventsHandler
{

    /**
     * @var \Karma\Jobs\Mailer\JobApplyMailer
     */
    private $jobApplyMailer;

    /**
     * @param JobApplyMailer $jobApplyMailer
     */
    function __construct(JobApplyMailer $jobApplyMailer)
    {
        $this->jobApplyMailer = $jobApplyMailer;
    }

    /**
     * @param $data
     */
    public function onJobApply($data)
    {
        $this->jobApplyMailer->sendEmail($data);
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        $events->listen('job.apply', 'Karma\Jobs\Events\JobApplyEventsHandler@onJobApply');
    }

} 