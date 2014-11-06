<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 10:49 AM
 */

namespace Karma\Profile;


use Karma\Users\CopUser;

class CopAccountActivationHandler
{

    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;

    public function __construct(CopUser $copUser)
    {
        $this->copUser = $copUser;
    }

    /**
     * @param $post
     * @return mixed
     * @throws \Exception
     */
    public function accountActivation($post)
    {
        $email = $post->userEmail;
        $activationCode = $post->activationCode;

        \CustomHelper::postCheck($post,
            array('userEmail' => 'required',
                'activationCode' => 'required'),
            2);
        $user = $this->copUser->checkActivationCode($email, $activationCode);
        if ($user) {
            $user->userId = $user->userId;
            $user->userEmailVerification = 'Y';
            $user->save();
            return \Lang::get('messages.account_activation_successful');
        }
        throw new \Exception('errors.invalid_activation_code');
    }
} 