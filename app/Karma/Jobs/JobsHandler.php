<?php
/**
 * User: Prakash
 * Date: 10/10/14
 * Time: 8:54 PM
 */

namespace Karma\Jobs;

use Karma\Cache\JobCacheHandler;
use Karma\General\Address;
use Karma\Log\CopInternalLog\CopInternalLogHandler;


class JobsHandler
{

    /**
     * @var Jobs
     */
    private $jobs;
    /**
     * @var \Karma\Cache\JobCacheHandler
     */
    private $jobCacheHandler;


    /**
     * @param Jobs $jobs
     * @param JobCacheHandler $jobCacheHandler
     */
    public function __construct(Jobs $jobs, JobCacheHandler $jobCacheHandler)
    {
        $this->jobs = $jobs;
        $this->jobCacheHandler = $jobCacheHandler;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function addJob($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'jobUserId' => 'required',
                'jobTitle' => 'required',
                'jobTypeId' => 'required',
                'jobProfessionId' => 'required',
                'jobSkills' => 'required|array',
                'jobExp' => 'required',
                'jobOpen' => 'required',
                'jobAddressCoordinate' => 'required',
                'jobSummary' => 'required',
                'jobExpDate' => 'required|date'),
            11);

        $userToken = $data->userToken;
        $userId = $data->jobUserId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // add job if token id and user id is valid
        $job = $this->jobs;


        $address = false;
        if (isset($data->jobAddressCoordinate) && !empty($data->jobAddressCoordinate)) {
            $address = \CustomHelper::getAddressFromApi($data->jobAddressCoordinate);
            if ($address) {
                $address = Address::makeAddress($address, $address->countryISO);
            }
        }

        $job->jobCountryISO = $address ? $address->addressCountryISO : 0;
        $job->jobAddressId = $address ? $address->addressId : 0;
        $job->jobAddressCoordinate = $data->jobAddressCoordinate;
        $job->jobUserId = $data->jobUserId;
        $job->jobTitle = $data->jobTitle;
        $job->jobProfessionId = $data->jobProfessionId;
        $job->jobTypeId = $data->jobTypeId;
        $job->jobOpen = $data->jobOpen;
        $job->jobSkills = implode(',', $data->jobSkills);
        $job->jobSummary = $data->jobSummary;
        $job->jobExpDate = $data->jobExpDate;
        $job->jobExp = $data->jobExp;

        ///save
        $result = $job->save();
        $jobId = $job->jobId;

        if ($result) {
            // select only what is needed
            $job = $this->jobs->selectById($jobId);
            // add internal log
            CopInternalLogHandler::addInternalLog($userId, $data);

            // create cache for user
            $this->jobCacheHandler->make($job, $jobId, $userId);

            return \Lang::get('messages.job.job_store_successful');
        }

        throw new \Exception(\Lang::get('errors.something_went_wrong'));
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function updateJob($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'jobUserId' => 'required',
                'jobId' => 'required',
                'jobTitle' => 'required',
                'jobTypeId' => 'required',
                'jobProfessionId' => 'required',
                'jobSkills' => 'required|array',
                'jobExp' => 'required',
                'jobOpen' => 'required',
                'jobAddressCoordinate' => 'required',
                'jobSummary' => 'required',
                'jobExpDate' => 'required|date'),
            12);

        $userToken = $data->userToken;
        $userId = $data->jobUserId;
        $jobId = $data->jobId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // add job if token id and user id is valid
        $job = $this->jobs
            ->where('jobDelete', '=', 'N')
            ->where('jobUserId', '=', $userId)
            ->find($jobId);

        if ($job) {

            $address = false;
            if (isset($data->jobAddressCoordinate) && !empty($data->jobAddressCoordinate)) {
                $address = \CustomHelper::getAddressFromApi($data->jobAddressCoordinate);
                if ($address) {
                    $address = Address::makeAddress($address, $address->countryISO);
                }
            }

            $job->jobCountryISO = $address ? $address->addressCountryISO : 0;
            $job->jobAddressId = $address ? $address->addressId : 0;
            $job->jobAddressCoordinate = $data->jobAddressCoordinate;
            $job->jobUserId = $data->jobUserId;
            $job->jobTitle = $data->jobTitle;
            $job->jobProfessionId = $data->jobProfessionId;
            $job->jobTypeId = $data->jobTypeId;
            $job->jobOpen = $data->jobOpen;
            $job->jobSkills = implode(',', $data->jobSkills);
            $job->jobSummary = $data->jobSummary;
            $job->jobExpDate = $data->jobExpDate;
            $job->jobExp = $data->jobExp;
            $job->jobId = $data->jobId;
        }
        $result = $job->save();

        if ($result) {
            // select only what is needed
            $job = $this->jobs->selectById($jobId);
            // add internal log
            CopInternalLogHandler::addInternalLog($userId, $data);
            // create cache for user
            $this->jobCacheHandler->make($job, $jobId, $userId);

            return \Lang::get('messages.job.job_update_successful');
        }
        throw new \Exception(\Lang::get('errors.something_went_wrong'));
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    function detailsById($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken',
                'jobUserId',
                'jobId'),
            3);
        $userToken = $data->userToken;
        $userId = $data->jobUserId;
        $jobId = $data->jobId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        $result = $this->jobs
            ->where('jobDelete', '=', 'N')
            ->find($jobId);

        if ($result) {
            return $result;
        }
        throw new \Exception(\Lang::get('errors.job_not_found'));
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function destroy($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken',
                'jobUserId',
                'jobId'),
            3);
        $userToken = $data->userToken;
        $userId = $data->jobUserId;
        $jobId = $data->jobId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // add job if token id and user id is valid
        $job = $this->jobs
            ->where('jobDelete', '=', 'N')
            ->find($jobId);

        if ($job) {
            $job->jobDelete = 'Y';
            $job->jobId = $data->jobId;

            $result = $job->save();
            if ($result) {
                return \Lang::get('messages.job.job_delete_successful');
            }
        }
        throw new \Exception(\Lang::get('errors.something_went_wrong'));
    }
}