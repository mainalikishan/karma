<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 10:49 AM
 */

namespace Karma\Profile;


use Karma\Users\CopUser;
use Karma\Users\CopUserRepository;

class CopUserForgotPasswordRequestHandler
{

    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Users\CopUserRepository
     */
    private $copUserRepository;

    function __construct(CopUser $copUser, CopUserRepository $copUserRepository)
    {
        $this->copUser = $copUser;
        $this->copUserRepository = $copUserRepository;
    }

    public function codeRequest($post)
    {
        $email = $post->userEmail;

        // get four digit verification code;
        $activationCode =  \CustomHelper::generateRandomDigitCode();

        \CustomHelper::postCheck($post, array('userEmail'), 1);
        $user = $this->copUser->checkEmail($email);
        if ($user) {
            $user->userId = $user->userId;
            $user->userPasswordRequestVerificationCode = $activationCode;
            $this->copUserRepository->save($user);
            return $user;
        }
        throw new \Exception(\Lang::get('errors.invalid_email_address'));

    }
} 