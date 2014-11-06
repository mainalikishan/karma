<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 10:49 AM
 */

namespace Karma\Profile;

use Karma\Users\CopUser;
use Karma\Users\CopUserRepository;

class CopUserForgotPasswordVerifyHandler
{

    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Users\CopUserRepository
     */
    private $copUserRepository;

    /**
     * @param CopUser $copUser
     * @param CopUserRepository $copUserRepository
     */
    function __construct(CopUser $copUser, CopUserRepository $copUserRepository)
    {
        $this->copUser = $copUser;
        $this->copUserRepository = $copUserRepository;
    }

    /**
     * @param $post
     * @return array
     * @throws \Exception
     */
    public function verifyCode($post)
    {
        $email = $post->userEmail;
        $userCode = $post->userCode;

        \CustomHelper::postCheck($post,
            array('userEmail'=> 'required',
                'userCode'=> 'required'),
            2);
        $user = $this->copUser->checkForgotPasswordCode($email,$userCode);
        if ($user) {
            $newPassword = \CustomHelper::generateRandomCharacters();
            $user->userId = $user->userId;
            $user->userPassword = \Hash::Make($newPassword);
            $user->userPasswordRequestVerificationCode=0;
            $this->copUserRepository->save($user);
            $newPassword = array('password'=>$newPassword,'name'=>$user->userCompanyName,'email'=>$email);
            $obj_merged = (object) array_merge((array) $newPassword);
            return array('user' => $obj_merged, 'success' => \Lang::get('messages.profile.password_verification_successful'));
        }
        throw new \Exception(\Lang::get('errors.invalid_code_email_address'));

    }
} 