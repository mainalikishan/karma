<?php
namespace Karma\Users;

class CopUser extends \Eloquent {
    const CREATED_AT ='userRegDate';
    const UPDATED_AT ='userUpdatedDate';
    protected $fillable =['userCompanyName','userEmail','userPassword'];
    protected $CopUserRepository;

   //database table used by model
    protected $table ='cop_user';

    public static function register($userCompanyName, $userEmail, $userPassword)
    {
        $user =  new static (compact('userCompanyName','userEmail','userPassword'));
        return $user;
    }

}