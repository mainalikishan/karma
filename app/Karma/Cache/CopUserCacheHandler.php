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
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Log\ProfileViewLog\CopProfileViewLogHandler;
use Karma\Users\IndUser;

class CopUserCacheHandler
{

    private $copUserCache;


    /**
     * @param CopUserCache $copUserCache
     */
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


    /**
     * @param array $data
     * @param $updateType
     * @return array|mixed
     */
    public function buildUpdateType($data = [], $updateType)
    {
        switch ($updateType) {
            case "basic":
                $country = Country::selectCountryNameByISO($data->userCountryISO);
                $address = Address::selectAddress($data->userAddressId);
                $industryType = ($data->userIndustryTypeId > 0) ? IndustryType::selectGenderName($data->userIndustryTypeId) : 0;
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
            case "preference":
                return json_decode($data->preferenceData, true);
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


    /**
     * @param $data
     * @return mixed
     */
    public function viewProfile($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'viewerId' => 'required',
                'userId' => 'required',
                'type' => 'required'
            ),
            4);

        $userToken = $data->userToken;
        $viewerId = $data->viewerId;
        $userId = $data->userId;
        $type = $data->type;


        //add internal log
        CopInternalLogHandler::addInternalLog($userId, $data);


        if ($type == 'indUser') {
            //checking for valid token id and user id
            IndUser::loginCheck($userToken, $viewerId);
            $result = $this->copUserCache
                ->select('cacheValue')
                ->where('cacheUserId', $userId)
                ->first();

            //add profile view log
            CopProfileViewLogHandler::addProfileViewLog($viewerId, $userId, 'ind');

            return ($result) ? json_decode($result->cacheValue) : \Lang::get('error.profile.profile_not_found');

        } else if ($type == 'copUser') {
            //checking for valid token id and user id
            \CopUserLoginCheck::loginCheck($userToken, $viewerId);
            $result = $this->copUserCache
                ->select('cacheValue')
                ->where('cacheUserId', $userId)
                ->first();

            //add profile view log
            CopProfileViewLogHandler::addProfileViewLog($viewerId, $userId, 'cop');

            return ($result) ? json_decode($result->cacheValue) : \Lang::get('error.profile.profile_not_found');
        }

        return \Lang::get('error.profile.profile_not_found');

    }
}