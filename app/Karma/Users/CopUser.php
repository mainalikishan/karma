<?php
namespace Karma\Users;

class CopUser extends \Eloquent
{
    const CREATED_AT = 'userRegDate';
    const UPDATED_AT = 'userUpdatedDate';
    protected $primaryKey = 'userId';

    protected $fillable = ['userCompanyName', 'userEmail', 'userPassword', 'userOuthType', 'userOauthId', 'userEmailVerificationCode'];
    protected $CopUserRepository;

    //database table used
    protected $table = 'cop_user';

    public static function register($userCompanyName, $userEmail, $userPassword, $userOuthType, $userOauthId, $userEmailVerificationCode)
    {
        $user = new static (compact('userCompanyName', 'userEmail', 'userPassword', 'userOuthType', 'userOauthId', 'userEmailVerificationCode'));
        return $user;
    }

    public static function getUser($username)
    {
        $user = \DB::table('cop_user')
            ->select('userId', 'userIndustryTypeId', 'userCountryId', 'userAddressId', 'userCompanyPhone', 'userCompanyName', 'userEmail', 'userSummary', 'userCoverPic', 'userProfilePic', 'userStatus', 'userAccountStatus', 'userOuthType', 'userOauthId', 'userLoginCount', 'userEmailVerificationCode', 'userEmailVerification')
            ->where('userEmail', $username)
            ->where('userAccountStatus', '<>', 'perDeactivate')
            ->where('userStatus', 'Y')->first();
        return $user;
    }

    public static function getUserById($userId)
    {
        $user = \DB::table('cop_user')
            ->select('userId', 'userIndustryTypeId', 'userCountryId', 'userAddressId', 'userCompanyPhone', 'userCompanyName', 'userEmail', 'userSummary', 'userCoverPic', 'userProfilePic', 'userOuthType', 'userOauthId')
            ->where('userId', $userId)
            ->where('userAccountStatus', '<>', 'perDeactivate')
            ->where('userStatus', 'Y')
            ->get();
        return $user;
    }

    // updating login information
    public static function updateUserLoginInfo($userId, $userLoginCount, $userLoginIp, $userToken)
    {
        \DB::table('cop_user')
            ->where('userId', $userId)
            ->update(array('userLoginCount' => $userLoginCount,
                'userLoginIp' => $userLoginIp,
                'userToken' => $userToken,
                'userUpdatedDate' => date('Y-m-d H:i:s'),
                'userAccountStatus' => 'Active'
            ));
    }

    // updating login information
    public static function loginLog($userId, $logLoginAgent, $userLoginIp)
    {
        \DB::table('cop_login_log')
            ->insert(array('logLoginAgent' => $logLoginAgent,
                'loginUserId' => $userId,
                'logLoginIp' => $userLoginIp,
                'logAddedDate' => date('Y-m-d H:i:s')
            ));
    }

    // updating user profile information
    public static function updateUserProfileInfo($userId,
                                                 $userToken,
                                                 $userIndustryTypeId,
                                                 $userCountryId,
                                                 $userAddressId,
                                                 $userCompanyPhone,
                                                 $userCompanyName,
                                                 $userSummary)
    {
        \DB::table('cop_user')
            ->where('userId', $userId)
            ->where('userToken', $userToken)
            ->update(array('userIndustryTypeId' => $userIndustryTypeId,
                'userCountryId' => $userCountryId,
                'userAddressId' => $userAddressId,
                'userCompanyPhone' => $userCompanyPhone,
                'userCompanyName' => $userCompanyName,
                'userSummary' => $userSummary,
                'userUpdatedDate' => date('Y-m-d H:i:s')
            ));
    }

    public function fetchPassword($userId)
    {
        $user = $this->select(array('userId', 'userPassword'))->where(compact('userId'))->first();
        if ($user) {
            return $user;
        }
        return false;
    }

    public function checkActivationCode($userEmail, $userEmailVerificationCode)
    {
        $user = $this->select(array('userEmail', 'userEmailVerificationCode', 'userId'))
            ->where(compact('userEmail', 'userEmailVerificationCode'))
            ->first();
        if ($user) {
            return $user;
        }
        return false;
    }
}