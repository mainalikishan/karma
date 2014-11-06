<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 9:42 PM
 */

namespace Karma\Profile\Mailer;


class CopUserPasswordCodeRequest {
    private $toEmail = '';
    private $name = '';

    /**
     * @param $data
     */
    public function sendEmail($data)
    {
        $this->toEmail = $data->userEmail;
        $this->name = $data->userCompanyName;

        \Mail::send('emails.ForgotPassword.copForgotPasswordCodeRequestEmail', array('name' => $data->userCompanyName,'code' => $data->userPasswordRequestVerificationCode,'logo'=>DEFAULT_EMAIL_LOGO,'signature'=>DEFAULT_EMAIL_SIGNATURE), function ($message) {
            $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
            $message->to($this->toEmail, $this->name)->subject(DEFAULT_PASSWORD_CODE_REQUEST_SUBJECT);
        });
    }
} 