<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 9:42 PM
 */

namespace Karma\Profile\Mailer;


class CopUserPasswordCodeVerify {
    private $toEmail = '';
    private $name = '';

    public function sendEmail($data)
    {
        $this->toEmail = $data->email;
        $this->name = $data->name;

        \Mail::send('emails.ForgotPassword.copForgotPasswordCodeVerifyEmail', array('name' => $data->name,'code' => $data->password,'logo'=>DEFAULT_EMAIL_LOGO,'signature'=>DEFAULT_EMAIL_SIGNATURE), function ($message) {
            $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
            $message->to($this->toEmail, $this->name)->subject(DEFAULT_PASSWORD_RESET_SUBJECT);
        });
    }
} 