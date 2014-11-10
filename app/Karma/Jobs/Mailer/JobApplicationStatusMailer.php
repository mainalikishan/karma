<?php
/**
 * User: Prakash
 * Date: 10/30/14
 * Time: 9:22 PM
 */

namespace Karma\Jobs\Mailer;


use Illuminate\Support\Facades\Lang;
use Karma\Jobs\Jobs;
use Karma\Users\CopUser;
use Karma\Users\IndUser;

class JobApplicationStatusMailer
{

    private $fromName = '';
    private $toName = '';
    private $toEmail = '';
    private $jobTitle = '';
    private $applicationStatus = '';
    private $bodyMessage = '';

    /**
     * @param $data
     */
    public function sendEmail($data)
    {

        //job info
        $job=$this->jobTitle = Jobs::jobTitleById($data->appJobId);
        $this->jobTitle=$job['title'];


        //from
        $copUser = CopUser::selectNameEmail($data->userId);
        $this->fromName = $copUser['name'];

        //to
        $indUser = IndUser::selectNameEmail($data->indUserId);
        $this->toName = $indUser['name'];
        $this->toEmail = $indUser['email'];
        $this->applicationStatus = Lang::get('keys.applications_status.' . $data->statusName);

        $this->bodyMessage = "Your application has been ".$this->applicationStatus;


        \Mail::send('emails.Jobs.applicationStatusChange',
            array('toName' => $this->toName,
                'fromName' => $this->fromName,
                'jobTitle' => $this->jobTitle,
                'messages' => $this->bodyMessage,
                'logo' => DEFAULT_EMAIL_LOGO,
                'signature' => DEFAULT_EMAIL_SIGNATURE),
            function ($message) {
                $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
                $message->to($this->toEmail, $this->toName)->subject($this->fromName . ": your application has been " . $this->applicationStatus);
            });
    }
} 