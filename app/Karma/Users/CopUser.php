<?php
namespace Karma\Users;

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


    public  function getUser($username)
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

    public  function getUserById($userId)
    {
        $user = $this->where('userId',$userId)
            ->where('userAccountStatus','<>','perDeactivate')
            ->where('userStatus', 'Y')
            ->first();
        return $user;
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

    public function checkEmail($userEmail)
    {
        $user = $this->select(array('userCompanyName', 'userEmail', 'userPasswordRequestVerificationCode', 'userId'))
            ->where(compact('userEmail'))
            ->first();
        if ($user) {
            return $user;
        }
        return false;
    }

    public function checkForgotPasswordCode($userEmail, $userPasswordRequestVerificationCode)
    {
        $user = $this->select(array('userCompanyName', 'userEmail', 'userPasswordRequestVerificationCode', 'userId'))
            ->where(compact('userEmail', 'userPasswordRequestVerificationCode'))
            ->first();
        if ($user) {
            return $user;
        }
        return false;
    }
}