<?php
/**
 * User: kishan
 * Date: 9/21/14
 * Time: 7:38 AM
 */

namespace Karma\Users;


class IndUser extends \Eloquent
{
    const CREATED_AT = 'userRegDate';
    const UPDATED_AT = 'userLastUpdated';
    protected $primaryKey = 'userId';

    protected $guarded = array('userId');

    protected $fillable = array(
        'userGenderId',
        'userCountryISO',
        'userAddressId',
        'userAddressCoordinate',
        'userDynamicAddressCoordinate',
        'userProfessionId',
        'userSkillIds',
        'userFname',
        'userLname',
        'userEmail',
        'userPassword',
        'userToken',
        'userDOB',
        'userOauthId',
        'userOauthType',
        'userSummary',
        'userPic',
        'userRegDate',
        'userLastLogin',
        'userLoginCount',
        'userLastLoginIp',
        'userStatus',
        'userAccountStatus'
    );

    protected $table = 'ind_user';

    /**
     * @return static
     */
    public function register()
    {
        $args = func_get_args();
        $c = array_combine($this->fillable, $args);
        $user = new static ($c);
        return $user;
    }


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
     * @param $userToken
     * @param $userId
     * @return bool
     */
    public static function loginCheck($userToken, $userId)
    {
        $user = self::where(compact('userToken', 'userId'))->first();
        if ($user) {
            if ($userId == $user->userId && $userToken == $user->userToken) {
                \CustomHelper::setUserTimeZone($user->userAddressId);
                return $user;
            }
        }
        return false;
    }


    /**
     * @param $userId
     * @return array|bool
     */
    public static function selectNameEmail($userId)
    {
        $user = self::select(array('userFname', 'userLname', 'userEmail'))
            ->where(compact('userId'))
            ->first();
        if ($user) {
            return
                array('name' => $user->userFname . ' ' . $user->userLname,
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
} 