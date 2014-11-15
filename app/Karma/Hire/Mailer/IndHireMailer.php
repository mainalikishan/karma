<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 9:10 PM
 */

namespace Karma\Hire\Mailer;


use Karma\Users\CopUser;
use Karma\Users\IndUser;

class IndHireMailer
{

    public function sendEmail($data)
    {
        //from
        if ($data->hireByUserType == "copUser") {
            $copUser = CopUser::selectNameEmail($data->hireById);
            $this->fromName = $copUser['name'];
        } else {
            $indUser = IndUser::selectNameEmail($data->hireById);
            $this->fromName = $indUser['name'];
        }

        //to
        $indUser = IndUser::selectNameEmail($data->hireToId);
        $this->toName = $indUser['name'];
        $this->toEmail = $indUser['email'];


        \Mail::send('emails.Hire.indHireEmail',
            array('toName' => $this->toName,
                'fromName' => $this->fromName,
                'logo' => DEFAULT_EMAIL_LOGO,
                'signature' => DEFAULT_EMAIL_SIGNATURE),
            function ($message) {
                $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
                $message->to($this->toEmail, $this->toName)->subject($this->fromName . " Hire Request ");
            });
    }
}