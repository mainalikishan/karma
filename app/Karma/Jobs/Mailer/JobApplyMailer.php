<?php
/**
 * User: Prakash
 * Date: 10/30/14
 * Time: 9:22 PM
 */

namespace Karma\Jobs\Mailer;


use Karma\Jobs\Jobs;
use Karma\Users\CopUser;
use Karma\Users\IndUser;

class JobApplyMailer
{

    private $fromName = '';
    private $toName = '';
    private $toEmail = '';
    private $jobTitle = '';
    private $jobSummary = '';

    public function sendEmail($data)
    {

        //job info
        $job=$this->jobTitle = Jobs::jobTitleById($data->appJobId);
        $this->jobTitle=$job['title'];
        $this->jobSummary=$job['summary'];

        //to
        $copUser = CopUser::selectNameEmail($data->appCopUserId);
        $this->toEmail = $copUser['email'];
        $this->toName = $copUser['name'];

        //from
        $indUser = IndUser::selectNameEmail($data->appIndUserId);
        $this->fromName = $indUser['name'];

        \Mail::send('emails.Jobs.jobApply',
            array('toName' => $this->toName,
                'fromName' => $this->fromName,
                'jobTitle' => $this->jobTitle,
                'jobSummary' => $this->jobSummary,
                'logo' => DEFAULT_EMAIL_LOGO,
                'signature' => DEFAULT_EMAIL_SIGNATURE),
            function ($message) {
                $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
                $message->to($this->toEmail, $this->toName)->subject($this->fromName . " applied for " . $this->jobTitle);
            });
    }
} 