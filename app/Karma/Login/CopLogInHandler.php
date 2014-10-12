<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:43 PM
 */

namespace Karma\Login;

use Karma\Users\CopUser;

class CopLogInHandler
{

    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;

    public function __construct(CopUser $copUser)
    {

        $this->copUser = $copUser;
    }

    public function login($data)
    {

        $user = CopUser:: getUser($data->userEmail);

        if ($user) {
            if (\Hash::check($data->userPassword, $user->userPassword)) {
                //updating cop user table with login information
                $userLoginCount = $user->userLoginCount + 1;
                $userId = $user->userId;
                $userLoginIp = \Request::getClientIp(true);
                $userToken = \CustomHelper::generateToken($user->userEmail);
                CopUser::updateUserLoginInfo($userId, $userLoginCount, $userLoginIp, $userToken);

                // add internal log
                CopInternalLogHandler:: addInternalLog($userId);
                return CopUser:: getUser($user->userEmail);
            }
        }
        throw new \Exception('Invalid username or password');
    }
} 