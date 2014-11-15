<?php
/**
 * User: Prakash
 * Date: 11/15/14
 * Time: 08:28 PM
 */

namespace Karma\Registration\Mailer;


class IndRegisterMailer
{
    private $toEmail = '';
    private $name = '';

    /**
     * @param $data
     */
    public function sendWelcomeEmail($data)
    {
        $this->toEmail = $data->userEmail;
        $this->name = $data->userFname;

        \Mail::send('emails.Registration.indRegisterEmail',
            array('name' => $data->userFname,
                'logo' => DEFAULT_EMAIL_LOGO,
                'signature' => DEFAULT_EMAIL_SIGNATURE),
            function ($message) {
                $message->from(DEFAULT_FROM_EMAIL, DEFAULT_FROM_NAME);
                $message->to($this->toEmail, $this->name)->subject(DEFAULT_WELCOME_SUBJECT);
            });
    }
} 