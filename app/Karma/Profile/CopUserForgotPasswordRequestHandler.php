<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 10:49 AM
 */

namespace Karma\Profile;


use Karma\Users\CopUser;

class CopUserForgotPasswordRequestHandler
{

    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;


    /**
     * @param CopUser $copUser
     */
    public function __construct(CopUser $copUser)
    {
        $this->copUser = $copUser;
    }

    /**
     * @param $post
     * @return array
     * @throws \Exception
     */
    public function codeRequest($post)
    {
        $email = $post->userEmail;

        // get four digit verification code;
        $activationCode = \CustomHelper::generateRandomDigitCode();

        \CustomHelper::postCheck($post, array('userEmail' => 'required'), 1);
        $user = $this->copUser->checkEmail($email);
        if ($user) {
            $user->userId = $user->userId;
            $user->userPasswordRequestVerificationCode = $activationCode;
            $user->save();
            return array('user' => $user, 'success' => \Lang::get('messages.profile.password_verification_code_sent'));
        }
        throw new \Exception(\Lang::get('errors.profile.invalid_email_address'));

    }
} 