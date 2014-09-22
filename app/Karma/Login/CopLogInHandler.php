<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:43 PM
 */

namespace Karma\Login;

use Karma\Users\CopUser;

class CopLogInHandler {

    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;

    function __construct(CopUser $copUser)
    {

        $this->copUser = $copUser;
    }

    function login($data)
    {

        echo "success";

//        $user = CopUser::register(
//            $post->userCompanyName,
//            $post->userEmail,
//            \Hash::make($post->userPassword),
//            $post->userOuthType,
//            $post->userOauthId
//        );
//        $this->copUserRepository->save($user);
//        return $user;
    }
} 