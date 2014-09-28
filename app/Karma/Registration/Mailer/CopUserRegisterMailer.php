<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 12:32 PM
 */

namespace Karma\Registration\Mailer;


class CopUserRegisterMailer {

    public function sendWelcomeEmail($data){
        //dd('sent email');
        //dd($data);

        \Mail::send('emails.Registration.copRegisterEmail', array('Name' => 'Prakash'), function($message)
        {
            $message->from('norep@jagirr.com', 'Jagirr Test');

            $message->to('thebhandariprakash@gmail.com','Test user')->subject('Welcome!');

            //$message->attach($pathToFile);
        });
    }
} 