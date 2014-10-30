<?php
//cop users related events
Event::subscribe('Karma\Registration\Events\CopUserRegisterEventsHandler');
Event::subscribe('Karma\Profile\Events\CopUserPasswordCodeRequestEventsHandler');
Event::subscribe('Karma\Profile\Events\CopUserPasswordCodeVerifyEventsHandler');

//job and application related events
Event::subscribe('Karma\Jobs\Events\JobApplyEventsHandler');