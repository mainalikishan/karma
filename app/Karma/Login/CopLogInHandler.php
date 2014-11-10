<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:43 PM
 */

namespace Karma\Login;

use Karma\Cache\UserMasterCache;
use Karma\Log\CopActivityLog\CopActivityLogHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Setting\CopPreference;
use Karma\Users\CopUser;

class CopLogInHandler
{
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Cache\UserMasterCache
     */
    private $userMasterCache;

    public function __construct(
        CopUser $copUser,
        UserMasterCache $userMasterCache)
    {
        $this->copUser = $copUser;
        $this->userMasterCache = $userMasterCache;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function login($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data, array('userEmail' => 'required',
                'userPassword' => 'required'),
            2);

        $user = $this->copUser->getUser($data->userEmail);
        if ($user) {
            if (\Hash::check($data->userPassword, $user->userPassword)) {

                // updating cop user table with login information
                $user->userLoginCount = $user->userLoginCount + 1;
                $user->userLoginIp = \Request::getClientIp(true);
                $user->userToken = \CustomHelper::generateToken($user->userEmail);
                $user->save();

                // add internal log
                CopInternalLogHandler::addInternalLog($user->userId, $data);
                CopActivityLogHandler::addActivityLog($user->userId, "log text");

                // set user locale and timezone
                $preference = CopPreference::selectPreferenceByUserId($user->userId);
                if ($preference) {
                    $userLang = json_decode($preference->preferenceData)->langCode;
                    \CustomHelper::setUserLocaleTimeZone($user->userAddressId, $userLang);
                }

                // returns cache value
                return $this->userMasterCache->init('cop', $user->userId);
            }
        }
        return \Lang::get('errors.invalid_email_password_address');
    }
} 