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
    /**
     * @var JobsRepository
     */
    private $jobsRepository;

    public function __construct(Jobs $jobs, JobsRepository $jobsRepository)
    {
        $this->jobs = $jobs;
        $this->jobsRepository = $jobsRepository;
    }

    public function addJob($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken', 'jobUserId', 'jobCountryId', 'jobAddressId', 'jobSkills', 'jobSummary', 'jobExpDate', 'jobExp'),
            8);
        $userToken = $data->userToken;
        $userId = $data->jobUserId;

        $this->jobs->jobUserId = $data->jobUserId;
        $this->jobs->jobCountryId = $data->jobCountryId;
        $this->jobs->jobAddressId = $data->jobAddressId;
        $this->jobs->jobSkills = $data->jobSkills;
        $this->jobs->jobSummary = $data->jobSummary;
        $this->jobs->jobExpDate = $data->jobExpDate;
        $this->jobs->jobExp = $data->jobExp;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // add job if token id and user id is valid
        $result = $this->jobsRepository->save($this->jobs);
        if($result)
        {
            return \Lang::get('messages.job_post_successful');
        }
        throw new \Exception(\Lang::get('errors.something_went_wrong'));

    }
}