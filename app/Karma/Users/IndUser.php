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
        'userCountryId',
        'userAddressId',
        'userAddressCoordinate',
        'userDynamicAddressCoordinate',
        'userJobTitleId',
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

    // database table used by model
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

    public function loginCheck($userToken, $userId)
    {
        $user = $this->where(compact('userToken', 'userId'))->first();
        if ($user) {
            if ($userId == $user->userId && $userToken == $user->userToken) {
                return $user;
            }
        }
        return false;
    }
} 