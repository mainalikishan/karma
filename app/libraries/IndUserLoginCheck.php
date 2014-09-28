<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 1:21 PM
 */

class IndUserLoginCheck {


    /**
     * @param $tokenId
     * @param $userId
     * @return mixed
     * @throws Exception
     */
    public static function loginCheck($tokenId,$userId)
    {
        $user = \DB::table('ind_user')
            ->where('userId', $userId)
            ->where('userToken', $tokenId)->first();
        if($user)
        {
            if($userId==$user->userId && $tokenId==$user->userToken)
            {
                return $user;
            }
        }
        throw new \Exception('invalid token');
    }

}