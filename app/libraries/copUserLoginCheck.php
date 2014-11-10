<?php
use Karma\Setting\CopPreference;

/**
 * User: Prakash
 * Date: 9/27/14
 * Time: 11:12 AM
 */

class CopUserLoginCheck {

    public static function loginCheck($tokenId,$userId)
    {
        $user = \DB::table('cop_user')
            ->where('userId', $userId)
            ->where('userToken', $tokenId)->first();
        if($user)
        {
            if($userId==$user->userId && $tokenId==$user->userToken)
            {
                $preference = CopPreference::selectPreferenceByUserId($userId);
                if($preference) {
                    $userLang = json_decode($preference->preferenceData)->langCode;
                    \CustomHelper::setUserLocaleTimeZone($user->userAddressId, $userLang);
                }
                else {
                    throw new \Exception(\Lang::get('errors.something_went_wrong'));
                }
                return true;
            }
        }

        throw new \Exception(\Lang::get('errors.invalid_token'));
    }

} 