<?php
/**
 * User: kishan
 * Date: 11/2/14
 * Time: 10:14 PM
 */

namespace Karma\Setting;


use Karma\Cache\CopUserCacheHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;

class CopAppSettingHandler
{
    /**
     * @var \Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;


    /**
     * @return array
     */
    private function notifications()
    {
        return array(
            'message',
            'hireRequestConfirmation',
            'jobApplied'
        );
    }


    /**
     * @param CopUserCacheHandler $copUserCacheHandler
     */
    public function __construct(CopUserCacheHandler $copUserCacheHandler)
    {
        $this->copUserCacheHandler = $copUserCacheHandler;
    }


    /**
     * @param $post
     * @return mixed
     */
    public function update($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'notifications' => 'required|array'),
            3);

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($post->token, $post->userId);

        $notifications = [];
        foreach (array_map(NULL, $this->notifications(), $post->notifications) as $k) {
            list($notificationLabel, $notificationRule) = $k;
            $notifications[] = array("$notificationLabel" => $notificationRule);
        }
        $notifications = json_encode(array('notification'=>$notifications));

        $appSetting = CopAppSetting::selectAppSettingByUserId($post->userId);
        if ($appSetting) {
            $appSetting->settings = $notifications;
        } else {
            $appSetting = CopAppSetting::createAppSetting(
                $post->userId,
                $notifications);
        }
        $appSetting->save();

        // lets re-select after insert or update
        $appSetting = CopAppSetting::selectAppSettingByUserId($post->userId);

        // internal Log
        CopInternalLogHandler::addInternalLog($post->userId, $post);

        // create or update cache for user
        $return = $this->copUserCacheHandler->make($appSetting, 'setting', $post->userId);
        return $return;
    }
}