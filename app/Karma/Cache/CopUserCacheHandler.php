<?php
/**
 * User: Prakash
 * Date: 10/13/14
 * Time: 10:21 PM
 */

namespace Karma\Cache;

use Karma\General\Country;
use Karma\General\Address;
use Karma\General\IndustryType;

class CopUserCacheHandler
{

    /**
     * @var CopUserCache
     */
    private $copUserCache;

    public function __construct(CopUserCache $copUserCache)
    {

        $this->copUserCache = $copUserCache;
    }


    /**
     * @return array
     */
    private function cacheKeys()
    {
        return array('basic', 'preference', 'setting');
    }


    /**
     * @param array $data
     * @param $userId
     * @return mixed
     */
    public function create($data = [], $userId)
    {
        $collection = [];
        foreach ($this->cacheKeys() as $key) {
            if ($key === 'basic') {
                $data = $this->buildUpdateType($data, 'basic');
                $collection[$key] = $data;
            } else {
                $collection[$key] = '';
            }
        }

        $cache = $this->copUserCache->createCache($userId, json_encode($collection));
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
        $cache = $this->copUserCache->isCached($userId);
        if ($cache) {
            $collection = json_decode($cache->cacheValue, true);

            foreach ($this->cacheKeys() as $key) {
                if ($key === $updateType) {
                    $data = $this->buildUpdateType($data, $updateType);
                    $collection[$key] = $data;
                }
            }

            $cache->cacheUserId = $userId;
            $cache->cacheValue = json_encode($collection);
            $cache->save();
            return $this->copUserCache->selectCacheValue($userId);
        } else {
            $this->create($data, $userId);
            return $this->copUserCache->selectCacheValue($userId);
        }
    }

    public function buildUpdateType($data = [], $updateType)
    {
        switch ($updateType) {
            case "basic":
                $country = Country::selectCountryNameByISO($data->userCountryISO);
                $address = Address::selectAddress($data->userAddressId);
                $industryType = ($data->userIndustryTypeId>0)?IndustryType::selectGenderName($data->userIndustryTypeId):0;
                $data->industryType = $industryType;
                $data->userAddress = $address ? $address->addressName : '';
                $data->userAddressCoordinate = $address ? $address->addressCoordinate : '';
                $data->userCountry = $country ? $country->countryName : '';
                $data->userRegistered = $address ? \CustomHelper::dateConvertTimezone(
                    $data->userRegDate,
                    $address->addressTimeZone,
                    'toFormattedDateString') : \CustomHelper::dateConvertTimezone(
                    $data->userRegDate,
                    'UTC',
                    'toFormattedDateString');
                unset(
                $data->userAddressId,
                $data->userCountryISO,
                $data->userRegDate,
                $data->userIndustryTypeId
                );
                return $data;
                break;
            case "setting":
                $data = json_decode($data->settings);
                unset(
                $data->settingId,
                $data->settingUserId,
                $data->settingUpdatedDate,
                $data->settingAddedDate
                );
                return $data;
                break;
            default:
                return $data;
        }
    }
}