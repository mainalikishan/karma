<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 9:11 AM
 */

namespace Karma\Registration\Mailer;


class CopCustomRegister implements CopUserRegisterMailerInterface
{
    private $toEmail = '';
    private $name = '';

    /**
     * @param $data
     */
    public function sendWelcomeEmail($data)
    {
        $this->toEmail = $data->userEmail;
        $this->name = $data->userCompanyName;

        \Mail::send('emails.Registration.copCustomRegisterEmail',
            array('name' => $data->userCompanyName,
                'code' => $data->userEmailVerificationCode,
                'logo' => DEFAULT_EMAIL_LOGO,
                'signature' => DEFAULT_EMAIL_SIGNATURE),
            function ($message) {
                $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
                $message->to($this->toEmail, $this->name)->subject(DEFAULT_WELCOME_SUBJECT);
            });
    }
} 