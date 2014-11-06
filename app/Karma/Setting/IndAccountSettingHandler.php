<?php
/**
 * User: kishan
 * Date: 11/4/14
 * Time: 9:43 PM
 */

namespace Karma\Setting;

use Karma\Users\IndUser;

class IndAccountSettingHandler
{
    /**
     * @param $post
     * @return bool
     * @throws \Exception
     */
    public function updateAccountStatus($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'status' => 'required|enum=tempDeactivate|perDeactivate'),
            3);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);
        if($user) {
            $user->userAccountStatus = $post->status;
            $user->save();
            return true;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }
}