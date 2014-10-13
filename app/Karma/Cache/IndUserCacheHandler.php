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
use Karma\General\Profession;
use Karma\General\Skill;

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
        return array('basic', 'whatIDo', 'experience', 'education', 'preference', 'setting');
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

        $cache = $this->indUserCache->createCache($userId, json_encode($collection));
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
                    $data = $this->buildUpdateType($data, $updateType);
                    $collection[$key] = $data;
                }
            }

            $cache->cacheUserId = $userId;
            $cache->cacheValue = json_encode($collection);
            $cache->save();
            return $this->indUserCache->selectCacheValue($userId);
        } else {
            $this->create($data, $userId);
            return $this->indUserCache->selectCacheValue($userId);
        }
    }

    public function buildUpdateType($data = [], $updateType)
    {
        switch ($updateType) {
            case "basic":
                $gender = Gender::selectGenderName($data->userGenderId);
                $country = Country::selectCountryNameByISO($data->userCountryISO);
                $address = Address::selectAddress($data->userAddressId);
                $data->userGender = $gender;
                $data->userAddress = $address? $address->addressName: '';
                $data->userAddressCoordinate = $address? $address->addressCoordinate: '';
                $data->userCountry = $country ? $country->countryName : '';
                $data->userRegistered = $address? \CustomHelper::dateConvertTimezone(
                    $data->userRegDate,
                    $address->addressTimeZone,
                    'toFormattedDateString'): \CustomHelper::dateConvertTimezone(
                    $data->userRegDate,
                    'UTC',
                    'toFormattedDateString');
                unset(
                    $data->userGenderId,
                    $data->userAddressId,
                    $data->userCountryId,
                    $data->userRegDate
                );
                return $data;
                break;
            case "whatIDo":
                $profession =
                    is_numeric($data->userProfessionId)?
                    Profession::selectProfessionName($data->userProfessionId):
                    $data->userProfessionId;
                $skills = explode(',', $data->userSkillIds);
                $userSkills = [];
                foreach($skills as $skill) {
                    if(is_numeric($skill)) {
                        $userSkills[] = Skill::selectSkillName($skill);
                    }
                    else {
                        $userSkills[] = $skill;
                    }
                }
                $data->userProfession = $profession;
                $data->userSkills = $userSkills;
                unset(
                    $data->userProfessionId,
                    $data->userSkillIds
                );
                return $data;
                break;
            case "experience":
                return $data;
                break;
            case "education":
                return $data;
                break;
            default:
                return $data;
        }
    }
}