<?php
/**
 * User: Prakash
 * Date: 10/10/14
 * Time: 8:54 PM
 */

namespace Karma\Jobs;


class JobsHandler
{

    /**
     * @var Jobs
     */
    private $jobs;

    public function __construct(Jobs $jobs)
    {
        $this->jobs = $jobs;
    }

    public function addJob($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken',
                'jobUserId',
                'jobTitle',
                'jobTypeId',
                'jobOpen',
                'jobCountryId',
                'jobAddressId',
                'jobSkills',
                'jobSummary',
                'jobExpDate',
                'jobExp'),
            11);
        $userToken = $data->userToken;
        $userId = $data->jobUserId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // add job if token id and user id is valid
        $job = $this->jobs;

        $job->jobUserId = $data->jobUserId;
        $job->jobTitle = $data->jobTitle;
        $job->jobTypeId = $data->jobTypeId;
        $job->jobOpen = $data->jobOpen;
        $job->jobCountryId = $data->jobCountryId;
        $job->jobAddressId = $data->jobAddressId;
        $job->jobSkills = $data->jobSkills;
        $job->jobSummary = $data->jobSummary;
        $job->jobExpDate = $data->jobExpDate;
        $job->jobExp = $data->jobExp;

        ///save
        $result = $job->save();
        if ($result) {
            return \Lang::get('messages.job_store_successful');
        }
        throw new \Exception(\Lang::get('errors.something_went_wrong'));
    }

    public function updateJob($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken',
                'jobUserId',
                'jobTitle',
                'jobTypeId',
                'jobOpen',
                'jobCountryId',
                'jobAddressId',
                'jobSkills',
                'jobSummary',
                'jobExpDate',
                'jobExp',
                'jobId'),
            12);
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
            $job->jobUserId = $data->jobUserId;
            $job->jobTitle = $data->jobTitle;
            $job->jobTypeId = $data->jobTypeId;
            $job->jobOpen = $data->jobOpen;
            $job->jobCountryId = $data->jobCountryId;
            $job->jobAddressId = $data->jobAddressId;
            $job->jobSkills = $data->jobSkills;
            $job->jobSummary = $data->jobSummary;
            $job->jobExpDate = $data->jobExpDate;
            $job->jobExp = $data->jobExp;
            $job->jobId = $data->jobId;
        }
        $result = $job->save();
        if ($result) {
            return \Lang::get('messages.job_update_successful');
        }
        throw new \Exception(\Lang::get('errors.something_went_wrong'));
    }

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
                return \Lang::get('messages.job_delete_successful');
            }
        }
        throw new \Exception(\Lang::get('errors.something_went_wrong'));
    }

}