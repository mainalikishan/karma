<?php
namespace Karma\Users;

class CopUser extends \Eloquent {
    const CREATED_AT ='userRegDate';
    const UPDATED_AT ='userUpdatedDate';
    protected $fillable =['userCompanyName','userEmail','userPassword','userOuthType','userOauthId'];
    protected $CopUserRepository;

   //database table used
    protected $table ='cop_user';

    public static function register($userCompanyName, $userEmail, $userPassword,$userOuthType,$userOauthId)
    {
        $user =  new static (compact('userCompanyName','userEmail','userPassword','userOuthType','userOauthId'));
        return $user;
    }

}