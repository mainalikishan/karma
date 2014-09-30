<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 09:40 PM
 */
namespace Karma\Profile\Events;



use Karma\Profile\Mailer\CopUserPasswordCodeRequest;

class CopUserPasswordCodeRequestEventsHandler {


    /**
     * @var \Karma\Profile\Mailer\CopUserPasswordCodeRequest
     */
    private $copUserPasswordCodeRequest;

    function __construct(CopUserPasswordCodeRequest $copUserPasswordCodeRequest)
    {

        $this->copUserPasswordCodeRequest = $copUserPasswordCodeRequest;
    }

    public function onCodeRequest($data)
    {

        $this->copUserPasswordCodeRequest->sendEmail($data);
    }

    public function subscribe($events)
    {
        $events->listen('copUser.requestCode', 'Karma\Profile\Events\CopUserPasswordCodeRequestEventsHandler@onCodeRequest');
    }

}