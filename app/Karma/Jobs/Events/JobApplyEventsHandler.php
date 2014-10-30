<?php
/**
 * User: Prakash
 * Date: 10/30/14
 * Time: 7:31 AM
 */

namespace Karma\Jobs\Events;


class JobApplyEventsHandler
{

    public function onJobApply($data)
    {
        // $userOauthType = $data->userOauthType;
        // $this->$userOauthType->sendWelcomeEmail($data);
    }

    public function subscribe($events)
    {
        $events->listen('job.apply', 'Karma\Jobs\Events\JobApplyEventsHandler@onJobApply');
    }

} 