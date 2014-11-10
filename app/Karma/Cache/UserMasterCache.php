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
     * @var CopUserCache
     */
    private $copUserCache;


    /**
     * @param IndUserCache $indUserCache
     * @param CopUserCache $copUserCache
     */
    public function __construct(
        IndUserCache $indUserCache,
        CopUserCache $copUserCache
    )
    {
        $this->indUserCache = $indUserCache;
        $this->copUserCache = $copUserCache;
    }


    /**
     * @param $userType
     * @param $userId
     * @return array
     */
    public function init($userType, $userId)
    {
        $data = [];
        $data['profile'] = $this->selectCache($userType, $userId);
        $data['labels'] = $this->labels();
        $data['languages'] = $this->languages();
        $data['countries'] = $this->countries();
        $data['currencies'] = $this->currencies();
        return $data;
    }


    /**
     * @param $userType
     * @param $userId
     * @return mixed
     */
    private function selectCache($userType, $userId)
    {
        if($userType=='cop') {
            return $this->copUserCache->selectCacheValue($userId);
        }
        else {
            return $this->indUserCache->selectCacheValue($userId);
        }
    }


    /**
     * @return mixed
     */
    private function labels()
    {
        return \Lang::get('appLabels');
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