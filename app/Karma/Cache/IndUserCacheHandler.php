<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 2:28 PM
 */

namespace Karma\Cache;


use Karma\General\Gender;
use Karma\General\Country;
use Karma\General\Address;

class IndUserCacheHandler
{

    /**
     * @var IndUserCache
     */
    private $indUserCache;

    public function __construct(IndUserCache $indUserCache)
    {

        $this->indUserCache = $indUserCache;
    }


    /**
     * @return array
     */
    private function cacheKeys()
    {
        return array('basic', 'experience', 'education', 'whatIDo', 'preference', 'setting');
    }


    /**
     * @param $user
     * @return mixed
     */
    public function create($user)
    {
        $collection = [];
        foreach ($this->cacheKeys() as $key) {
            if ($key === 'basic') {
                $collection[$key] = $user;
            } else {
                $collection[$key] = '';
            }
        }

        $cache = $this->indUserCache->createCache($user->userId, json_encode($collection));
        return $cache->save();
    }


    /**
     * @param array $data
     * @param $updateType
     * @param $userId
     * @return mixed
     */
    public function make($data = [], $updateType, $userId)
    {
        $cache = $this->indUserCache->isCached($userId);
        if ($cache) {
            $collection = json_decode($cache->cacheValue, true);

            foreach ($this->cacheKeys() as $key) {
                if ($key === $updateType) {
                    if ($updateType == 'basic') {
                        $gender = Gender::selectGenderName($data->userGenderId);
                        $country = Country::selectCountryName($data->userCountryId);
                        $address = Address::selectAddress($data->userAddressId);
                        $data->userGender = $gender;
                        $data->userAddress =  $address->addressName;
                        $data->userAddressCoordinate =  $address->addressCoordinate;
                        $data->userCountry =  $country? $country : '';
                        $data->userRegistered = \CustomHelper::dateConvertTimezone($data->userRegDate, $address->addressTimeZone, 'toFormattedDateString');
                        unset($data->userGenderId, $data->userAddressId, $data->userCountryId, $data->userRegDate, $data->userSummary, $data->userJobTitleId);
                    }
                    $collection[$key] = $data;
                }
            }

            $cache->cacheUserId = $userId;
            $cache->cacheValue = json_encode($collection);
            $cache->save();
            return $this->indUserCache->selectCacheValue($userId);
        } else {
            $this->create($data);
            return $this->indUserCache->selectCacheValue($userId);
        }
    }
}