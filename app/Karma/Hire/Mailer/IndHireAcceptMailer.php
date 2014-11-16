<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 9:10 PM
 */

namespace Karma\Hire\Mailer;


use Karma\Users\CopUser;
use Karma\Users\IndUser;

class IndHireAcceptMailer
{

    public function sendEmail($data)
    {
        //tp
        if ($data->hireByUserType == "copUser") {
            $copUser = CopUser::selectNameEmail($data->hireById);
            $this->toName = $copUser['name'];
            $this->toEmail = $copUser['email'];
        } else {
            $indUser = IndUser::selectNameEmail($data->hireById);
            $this->toName = $indUser['name'];
            $this->toEmail = $indUser['email'];
        }

        //from
        $indUser = IndUser::selectNameEmail($data->hireToId);
        $this->fromName = $indUser['name'];



        \Mail::send('emails.Hire.indHireAcceptEmail',
            array('toName' => $this->toName,
                'fromName' => $this->fromName,
                'logo' => DEFAULT_EMAIL_LOGO,
                'default_name' => DEFAULT_FROM_NAME,
                'signature' => DEFAULT_EMAIL_SIGNATURE),
            function ($message) {
                $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
                $message->to($this->toEmail, $this->toName)->subject($this->fromName . " confirmed your Jagirr hire request‏");
            });
    }
}