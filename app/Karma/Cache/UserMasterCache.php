<?php
/**
 * User: kishan
 * Date: 11/6/14
 * Time: 9:09 PM
 */

namespace Karma\Cache;


use Karma\General\Country;
use Karma\General\Language;
use Karma\Setting\IndPreference;

class UserMasterCache
{

    /**
     * @var IndUserCache
     */
    private $indUserCache;


    /**
     * @param IndUserCache $indUserCache
     */
    public function __construct(IndUserCache $indUserCache)
    {
        $this->indUserCache = $indUserCache;
    }


    /**
     * @param $userId
     * @return array
     */
    public function init($userId)
    {
        $data = [];
        $data['profile'] = $this->selectCache($userId);
        $data['labels'] = $this->labels($userId);
        $data['languages'] = $this->languages();
        $data['countries'] = $this->countries();
        $data['currencies'] = $this->currencies();
        return $data;
    }


    /**
     * @param $userId
     * @return mixed
     */
    private function selectCache($userId)
    {
        return $this->indUserCache->selectCacheValue($userId);
    }


    /**
     * @param $userId
     * @return mixed
     */
    private function labels($userId)
    {
        $preference = IndPreference::selectPreferenceByUserId($userId);
        $userLang = json_decode($preference->preferenceData)->langCode;
        \App::setLocale($userLang);
        return \Lang::get('labels');
    }


    /**
     * @return mixed
     */
    private function languages()
    {
        return Language::selectLangAll();
    }


    /**
     * @return mixed
     */
    private function countries()
    {
        return Country::selectCountryAll();
    }


    /**
     * @return mixed
     */
    private function currencies()
    {
        return Country::selectCurrencyAll();
    }
}