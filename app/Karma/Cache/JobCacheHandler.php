<?php
/**
 * User: Prakash
 * Date: 10/19/14
 * Time: 9:07 PM
 */

namespace Karma\Cache;

use Karma\General\Country;
use Karma\General\Address;
use Karma\General\JobType;
use Karma\General\Profession;
use Karma\General\Skill;
use Carbon\Carbon;


class JobCacheHandler
{

    /**
     * @var JobCache
     */
    private $jobCache;

    function __construct(JobCache $jobCache)
    {
        $this->jobCache = $jobCache;
    }


    public function create($data = [], $jobId, $userId)
    {
        $data = $this->build($data);
        $cache = $this->jobCache->createCache($jobId, $userId, json_encode($data));
        return $cache->save();
    }

    /**
     * @param array $data
     * @param $jobId
     * @param $userId
     * @return mixed
     */
    public function make($data = [], $jobId, $userId)
    {
        $cache = $this->jobCache->isCached($jobId);
        if ($cache) {
            $cache->cacheDetails = $this->build($data);
            $cache->save();
            return $this->jobCache->selectCacheValue($jobId);
        } else {
            $this->create($data, $jobId, $userId);
            return $this->jobCache->selectCacheValue($jobId);
        }
    }

    public function build($data = [])
    {
        $country = Country::selectCountryNameByISO($data->jobCountryISO);
        $address = Address::selectAddress($data->jobAddressId);

        $data->userAddress = $address ? $address->addressName : '';
        $data->jobAddressCoordinate = $address ? $address->addressCoordinate : '';
        $data->jobCountry = $country ? $country->countryName : '';

        $profession[] = array('id'=>$data->jobProfessionId,'name'=>Profession::selectProfessionName($data->jobProfessionId));
        $data->profession =$profession;

        $skills = explode(',', $data->jobSkills);
        $jobSkills = [];
        foreach ($skills as $skill) {
            $jobSkills[] = array('id' => $skill, 'name' => Skill::selectSkillName($skill));
        }
        $data->jobSkills = $jobSkills;

        $data->jobType = JobType::selectJobType($data->jobTypeId);

        $data->jobPostedDate = $address ? \CustomHelper::dateConvertTimezone(
            $data->jobAddedDate,
            $address->addressTimeZone,
            'toFormattedDateString') : \CustomHelper::dateConvertTimezone(
            $data->jobAddedDate,
            'UTC',
            'toFormattedDateString');

        $dt = Carbon::parse($data->jobExpDate);

        $data->jobExpiryDate = $address ? \CustomHelper::dateConvertTimezone(
            $dt,
            $address->addressTimeZone,
            'toFormattedDateString') : \CustomHelper::dateConvertTimezone(
            $dt,
            'UTC',
            'toFormattedDateString');
        return $data;
    }

    function select($data)
    {

        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'jobUserId' => 'required',
                'jobId' => 'required'
            ),
            3);

        $userToken = $data->userToken;
        $userId = $data->jobUserId;
        $jobId = $data->jobId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        return $this->jobCache->selectCacheValueById($userId, $jobId);
    }
}