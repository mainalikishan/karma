<?php
/**
 * User: kishan
 * Date: 11/2/14
 * Time: 10:03 AM
 */

namespace Karma\Setting;


use Karma\Cache\IndUserCacheHandler;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\IndUser;

class IndAppSettingHandler
{

    /**
     * @var \Karma\Cache\IndUserCacheHandler
     */
    private $indUserCacheHandler;

    private function notifications()
    {
        return array(
            'message',
            'recommended',
            'hireRequest',
            'hireRequestConfirmation',
            'reviewAndRating'
        );
    }

    public function __construct(IndUserCacheHandler $indUserCacheHandler)
    {
        $this->indUserCacheHandler = $indUserCacheHandler;
    }

    public function update($post)
    {
        // verify post request
        \CustomHelper::postCheck($post,
            array(
                'userId' => 'required|integer',
                'token' => 'required',
                'notifications' => 'required|array'),
            3);

        // verify login info.
        $user = IndUser::loginCheck($post->token, $post->userId);
        if ($user) {
            $notifications = [];
            foreach (array_map(NULL, $this->notifications(), $post->notifications) as $k) {
                list($notificationLabel, $notificationRule) = $k;
                $notifications[] = array("$notificationLabel" => $notificationRule);
            }
            $notifications = json_encode(array('notification'=>$notifications));

            $appSetting = IndAppSetting::selectAppSettingByUserId($post->userId);
            if ($appSetting) {
                $appSetting->settings = $notifications;
            } else {
                $appSetting = IndAppSetting::createAppSetting(
                    $post->userId,
                    $notifications);
            }
            $appSetting->save();

            // lets re-select after insert or update
            $appSetting = IndAppSetting::selectAppSettingByUserId($post->userId);

            // internal Log
            IndInternalLogHandler::addInternalLog($post->userId, $post);

            // create or update cache for user
            $return = $this->indUserCacheHandler->make($appSetting, 'setting', $post->userId);
            return $return;
        }
        throw new \Exception(\Lang::get('errors.invalid_token'));
    }
}