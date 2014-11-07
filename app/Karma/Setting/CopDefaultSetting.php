<?php
/**
 * User: kishan
 * Date: 11/7/14
 * Time: 5:16 PM
 */

namespace Karma\Setting;


use Karma\Cache\CopUserCacheHandler;

class CopDefaultSetting
{

    /**
     * @var \Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;

    public function __construct(CopUserCacheHandler $copUserCacheHandler)
    {
        $this->copUserCacheHandler = $copUserCacheHandler;
    }

    /**
     * @param $userId
     */
    public function init($userId)
    {
        $this->appSettings($userId);
        $this->preference($userId);
    }


    /**
     * @param $userId
     */
    private function appSettings($userId)
    {
        $notifications = array(
            'message' => true,
            'hireRequestConfirmation' => true,
            'jobApplied' => true
        );
        $appSetting = CopAppSetting::createAppSetting($userId, 'en', json_encode($notifications));
        $appSetting->save();

        // create or update cache for user
        $this->copUserCacheHandler->make($appSetting, 'setting', $userId);
    }


    /**
     * @param $userId
     */
    private function preference($userId)
    {
        $preferenceData = array(
            'currencyCode' => 'USD',
            'langCode' => 'en'
        );
        $preference = CopPreference::createPreference($userId, json_encode($preferenceData));
        $preference->save();

        // create or update cache for user
        $this->copUserCacheHandler->make($preference, 'preference', $userId);
    }
}