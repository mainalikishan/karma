<?php
/**
 * User: kishan
 * Date: 11/2/14
 * Time: 8:58 PM
 */

namespace Karma\Setting;


use Karma\Cache\IndUserCacheHandler;

class IndDefaultSetting
{

    /**
     * @var \Karma\Cache\IndUserCacheHandler
     */
    private $indUserCacheHandler;


    /**
     * @param IndUserCacheHandler $indUserCacheHandler
     */
    public function __construct(IndUserCacheHandler $indUserCacheHandler)
    {
        $this->indUserCacheHandler = $indUserCacheHandler;
    }


    /**
     * @param $userId
     */
    public function init($userId)
    {
        $this->appSettings($userId);
        $this->preference($userId);
        $this->privacy($userId);
    }


    /**
     * @param $userId
     */
    private function appSettings($userId)
    {
        $notifications = array(
            'message' => true,
            'recommended' => true,
            'hireRequest' => true,
            'hireRequestConfirmation' => true,
            'reviewAndRating' => true
        );
        $appSetting = IndAppSetting::createAppSetting($userId, 'en', json_encode($notifications));
        $appSetting->save();

        // create or update cache for user
        $this->indUserCacheHandler->make($appSetting, 'setting', $userId);
    }


    /**
     * @param $userId
     */
    private function preference($userId)
    {
        $preferenceData = array(
            'workAs' => 'Contractor',
            'currencyCode' => 'USD',
            'minSalary' => '100',
            'salaryRule' => 'Yearly',
            'langCode' => 'en'
        );
        $preference = IndPreference::createPreference($userId, json_encode($preferenceData));
        $preference->save();

        // create or update cache for user
        $this->indUserCacheHandler->make($preference, 'preference', $userId);
    }


    /**
     * @param $userId
     */
    private function privacy($userId)
    {
        $privacyData = array(
            'inSearch' => true,
            'showEmail' => true,
            'showDOB' => true
        );
        $privacy = IndPrivacy::createPrivacy($userId, json_encode($privacyData));
        $privacy->save();

        // create or update cache for user
        $this->indUserCacheHandler->make($privacy, 'privacy', $userId);
    }
}