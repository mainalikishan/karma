<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:43 PM
 */

namespace Karma\Registration;


use Karma\Users\CopUserRepository;
use Karma\Users\CopUser;

class CopCustomRegister implements CopUserRegisterInterface {

    /**
     * @var \Karma\Users\CopUserRepository
     */
    private $copUserRepository;

public function __construct(CopUserRepository $copUserRepository)
    {
        $this->copUserRepository = $copUserRepository;
    }

public function register($post)
    {

        // check post array  fields
        \CustomHelper::postCheck($post, array('userCompanyName', 'userEmail', 'userPassword', 'userOuthType', 'userOauthId'), 5);

        // get four digit verification code
        $userEmailVerificationCode = \CustomHelper::generateRandomDigitCode();

        $user = CopUser::register(
            $post->userCompanyName,
            $post->userEmail,
            \Hash::make($post->userPassword),
            $post->userOuthType,
            $post->userOauthId,
            $userEmailVerificationCode
        );
        $this->copUserRepository->save($user);
        return $user;
    }
} 