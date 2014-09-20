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

    function __construct(CopUserRepository $copUserRepository)
    {
        $this->copUserRepository = $copUserRepository;
    }

    function register($post)
    {

        $user = CopUser::register(
            $post->userCompanyName,
            $post->userEmail,
            $post->userPassword
        );
        $this->copUserRepository->save($user);
        return $user;
    }
} 