<?php
/**
 * User: kishan
 * Date: 9/21/14
 * Time: 7:38 AM
 */

namespace Karma\Users;


class IndUser extends \Eloquent {
    const CREATED_AT ='userRegDate';
    const UPDATED_AT ='userLastUpdated';
    protected $fillable = array(
        'userGenderId',
        'userCountryId',
        'userAddressId',
        'userFname',
        'userLname',
        'userEmail',
        'userPassword',
        'userDOB',
        'userOuathId',
        'userOuathType',
        'userSummary',
        'userLastLogin',
        'userLoginCount',
        'userStatus',
        'userAccountStatus'
    );

    //database table used by model
    protected $table ='ind_user';

    public function register()
    {
        $args = func_get_args();
        $c = array_combine($this->fillable, $args);
        $user =  new static ($c);
        return $user;
    }
} 