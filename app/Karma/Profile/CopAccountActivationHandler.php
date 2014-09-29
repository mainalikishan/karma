<?php
/**
 * User: Prakash
 * Date: 9/29/14
 * Time: 10:49 AM
 */

namespace Karma\Profile;


use Karma\Users\CopUser;
use Karma\Users\CopUserRepository;

class CopAccountActivationHandler
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

    public function accountActivation($post)
    {
        $email = $post->userEmail;
        $activationCode = $post->activationCode;

        $user = $this->copUser->checkActivationCode($email,$activationCode);
        if ($user) {
            $user->userId= $user->userId;
            $user->userEmailVerification =   'Y';
            $this->copUserRepository->save($user);
            return \Lang::get('messages.account_activation_successful');
        }
        throw new \Exception('errors.invalid_activation_code');

    }
} 