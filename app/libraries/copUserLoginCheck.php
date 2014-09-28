<?php
/**
 * User: Prakash
 * Date: 9/27/14
 * Time: 11:12 AM
 */

class CopUserLoginCheck {

    public static function loginCheck($tokenId,$userId)
    {
        $user = \DB::table('cop_user')
            ->where('userId', $userId)
            ->where('userToken', $tokenId)->first();
        if($user)
        {
            if($userId==$user->userId && $tokenId==$user->userToken)
            {
                return true;
            }
        }
        throw new \Exception('invalid token');
    }

} 