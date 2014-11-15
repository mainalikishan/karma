<?php
//cop users related events
Event::subscribe('Karma\Registration\Events\CopUserRegisterEventsHandler');
Event::subscribe('Karma\Profile\Events\CopUserPasswordCodeRequestEventsHandler');
Event::subscribe('Karma\Profile\Events\CopUserPasswordCodeVerifyEventsHandler');
Event::subscribe('Karma\Review\Events\IndReviewEventsHandler');

//ind users related events
Event::subscribe('Karma\Registration\Events\IndUserRegisterEventsHandler');

//job and application related events
Event::subscribe('Karma\Jobs\Events\JobApplyEventsHandler');
Event::subscribe('Karma\Jobs\Events\JobApplicationStatusEventsHandler');

Event::subscribe('Karma\Hire\Events\IndHireRequestEventsHandler');
