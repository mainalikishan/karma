<?php
namespace Karma\Users;

class CopUser extends \Eloquent
{
    const CREATED_AT = 'userRegDate';
    const UPDATED_AT = 'userUpdatedDate';
    protected $fillable = ['userCompanyName', 'userEmail', 'userPassword', 'userOuthType', 'userOauthId'];
    protected $CopUserRepository;

    //database table used
    protected $table = 'cop_user';

    public static function register($userCompanyName, $userEmail, $userPassword, $userOuthType, $userOauthId)
    {
        $user = new static (compact('userCompanyName', 'userEmail', 'userPassword', 'userOuthType', 'userOauthId'));
        return $user;
    }


    public static function getUser($username)
    {
        $user = \DB::table('cop_user')
            ->where('userEmail', $username)
            ->where('userAccountStatus', '<>', 'perDeactivate')
            ->where('userStatus', 'Y')->first();
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
}