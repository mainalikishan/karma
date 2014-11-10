<?php
namespace Karma\Users;

use Karma\Setting\CopPreference;

class CopUser extends \Eloquent
{
    const CREATED_AT = 'userRegDate';
    const UPDATED_AT = 'userUpdatedDate';

    //primary key
    protected $primaryKey = 'userId';

    //database table used
    protected $table = 'cop_user';

    protected $fillable = ['userIndustryTypeId',
        'userCompanyName',
        'userCountryISO',
        'userAddressCoordinate',
        'userAddressId',
        'userCompanyPhone',
        'userEmail',
        'userSummary',
        'userCoverPic',
        'userProfilePic',
        'userPassword',
        'userLoginCount',
        'userLoginIp',
        'userOauthId',
        'userOauthType',
        'userStatus',
        'userEmailVerification',
        'userEmailVerificationCode',
        'userPasswordRequestVerificationCode',
        'userAccountStatus',
        'userReportCount'
    ];

    protected $CopUserRepository;


    /**
     * @param $userOauthId
     * @param $userOauthType
     * @return bool
     */
    public function isRegisted($userOauthId, $userOauthType)
    {
        $user = $this->where(compact('userOauthId', 'userOauthType'))->first();
        if ($user) {
            return $user;
        }
        return false;
    }


    /**
     * @param $username
     * @return mixed
     */
    public function getUser($username)
    {
        $user = $this->select('userId',
            'userIndustryTypeId',
            'userCountryISO',
            'userAddressId',
            'userCompanyPhone',
            'userCompanyName',
            'userEmail',
            'userSummary',
            'userCoverPic',
            'userProfilePic',
            'userStatus',
            'userAccountStatus',
            'userOauthType',
            'userOauthId',
            'userLoginCount',
            'userEmailVerificationCode',
            'userEmailVerification',
            'userPassword')
            ->where('userEmail', $username)
            ->where('userAccountStatus', '<>', 'perDeactivate')
            ->where('userEmailVerification', 'Y')
            ->where('userStatus', 'Y')->first();
        return $user;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function getUserById($userId)
    {
        $user = $this->where('userId', $userId)
            ->where('userAccountStatus', '<>', 'perDeactivate')
            ->where('userStatus', 'Y')
            ->first();
        return $user;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function fetchPassword($userId)
    {
        $user = $this->select(array('userId', 'userPassword'))->where(compact('userId'))->first();
        if ($user) {
            return $user;
        }
        return false;
    }

    /**
     * @param $userEmail
     * @param $userEmailVerificationCode
     * @return bool
     */
    public function checkActivationCode($userEmail, $userEmailVerificationCode)
    {
        $user = $this->select(array('userEmail',
            'userEmailVerificationCode',
            'userId'))
            ->where(compact('userEmail', 'userEmailVerificationCode'))
            ->first();
        if ($user) {
            return $user;
        }
        return false;
    }

    /**
     * @param $userEmail
     * @return bool
     */
    public function checkEmail($userEmail)
    {
        $user = $this->select(array('userCompanyName',
            'userEmail',
            'userPasswordRequestVerificationCode',
            'userId'))
            ->where(compact('userEmail'))
            ->first();
        if ($user) {
            return $user;
        }
        return false;
    }

    /**
     * @param $userEmail
     * @param $userPasswordRequestVerificationCode
     * @return bool
     */
    public function checkForgotPasswordCode($userEmail, $userPasswordRequestVerificationCode)
    {
        $user = $this->select(array('userCompanyName',
            'userEmail',
            'userPasswordRequestVerificationCode',
            'userId'))
            ->where(compact('userEmail',
                'userPasswordRequestVerificationCode'))
            ->first();
        if ($user) {
            return $user;
        }
        return false;
    }

    /**
     * @param $userId
     * @return array|bool
     */
    public static function selectNameEmail($userId)
    {
        $user = self::select(array('userCompanyName', 'userEmail'))
            ->where(compact('userId'))
            ->first();
        if ($user) {
            return
                array('name' => $user->userCompanyName,
                    'email' => $user->userEmail);
        }
        return false;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function updateReport($userId)
    {
        $user = $this->select(array('userReportCount', 'userId'))->where(compact('userId'))->first();
        if ($user) {
            $user->userReportCount = $user->userReportCount + 1;
            $user->save();
        }
        return false;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function selectById($userId)
    {
        // select only what is needed
        return $user = $this->select(array(
            'userId',
            'userIndustryTypeId',
            'userCountryISO',
            'userAddressId',
            'userAddressCoordinate',
            'userDynamicAddressCoordinate',
            'userCompanyPhone',
            'userCompanyName',
            'userEmail',
            'userCoverPic',
            'userProfilePic',
            'userSummary',
            'userRegDate',
            'userUpdatedDate',
            'userOauthId',
            'userOauthType',
            'userToken'
        ))
            ->where('userId', '=', $userId)
            ->first();
    }

    /**
     * @param $userToken
     * @param $userId
     * @return bool
     * @throws \Exception
     */
    public static function loginCheck($userToken, $userId)
    {
        $user = self::where(compact('userToken', 'userId'))->first();
        if ($user) {
            if ($userId == $user->userId && $userToken == $user->userToken) {
                $preference = CopPreference::selectPreferenceByUserId($userId);
                if($preference) {
                    $userLang = json_decode($preference->preferenceData)->langCode;
                    \CustomHelper::setUserLocaleTimeZone($user->userAddressId, $userLang);
                }
                else {
                    throw new \Exception(\Lang::get('errors.something_went_wrong'));
                }
                return $user;
            }
        }
        return false;
    }
}