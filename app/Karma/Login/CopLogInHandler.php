<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:43 PM
 */

namespace Karma\Login;

use Karma\Cache\CopUserCache;
use Karma\Log\CopActivityLog\CopActivityLogHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Users\CopUser;

class CopLogInHandler
{
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Cache\CopUserCache
     */
    private $copUserCache;

    public function __construct(CopUser $copUser, CopUserCache $copUserCache)
    {
        $this->copUser = $copUser;
        $this->copUserCache = $copUserCache;
    }

    public function login($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data, array('userEmail' => 'required',
                'userPassword' => 'required'),
            2);

        $user = $this->copUser->getUser($data->userEmail);
        if ($user) {
            if (\Hash::check($data->userPassword, $user->userPassword)) {

                //updating cop user table with login information
                $user->userLoginCount = $user->userLoginCount + 1;
                $user->userId = $user->userId;
                $user->userLoginIp = \Request::getClientIp(true);
                $user->userToken = \CustomHelper::generateToken($user->userEmail);
                $user->save();

                // add internal log
                CopInternalLogHandler::addInternalLog($user->userId, $data);
                CopActivityLogHandler::addActivityLog($user->userId, "log text");

                //returns cache value
                return $this->copUserCache->selectCacheValue($user->userId);
            }
        }
        return \Lang::get('errors.invalid_email_password_address');
    }
} 