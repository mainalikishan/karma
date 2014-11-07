<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 1:35 PM
 */

namespace Karma\Registration;


use Carbon\Carbon;
use Karma\Users\CopUser;

class CopLinkedInRegister implements CopUserRegisterInterface
{
    const oauthType = 'Linkedin';
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;


    /**
     * @param CopUser $copUser
     */
    public function __construct(CopUser $copUser)
    {
        $this->copUser = $copUser;
    }

    /**
     * @param $post
     * @param $address
     * @return bool|static
     */
    public function register($post, $address = false)
    {
        $user = $this->copUser->isRegisted($post->oauthId, self::oauthType);

        if ($user) {
            $action = 'login';
            $user->userLastLogin = Carbon::now();
            $user->userLoginCount = $user->userLoginCount + 1;
            $user->userLoginIp = \Request::getClientIp(true);
            $user->userDynamicAddressCoordinate = $post->addressCoordinate;
        } else {
            $action = 'register';
            $user = $this->copUser;

            $user->userCountryISO = $address? $address->addressCountryISO : 0;
            $user->userAddressId = $address? $address->addressId : 0;
            $user->userCompanyName = $userCompanyName = 'ABC Company';
            $user->userEmail = $userEmail = 'abc@jagirr.com';
            $user->userPassword = \Hash::make(\CustomHelper::generateRandomCharacters());
            $user->userOauthType = self::oauthType;
            $user->userOauthId = $userOauthId = '123456';
            $user->userAddressCoordinate = $post->userAddressCoordinate;
            $user->userDynamicAddressCoordinate = $post->userAddressCoordinate;
            $user->userCoverPic = $userCoverPic = null;
            $user->userProfilePic = $userProfilePic = null;
            $user->userSummary = $userSummary = null;
            $user->userRegDate = Carbon::now();
            $user->userUpdatedDate = Carbon::now();
            $user->userLoginCount = 1;
            $user->userLoginIp = \Request::getClientIp(true);
            $user->userStatus = 'Y';
            $user->userEmailVerification = 'Y';
            $user->userAccountStatus = 'Active';
        }

        $user->save();

        return array('action'=>$action, 'user'=>$user);
    }
}