<?php
/**
 * User: Prakash
 * Date: 11/9/14
 * Time: 12:35 PM
 */

namespace Karma\Jobs;


use Illuminate\Support\Facades\Lang;
use Karma\Cache\JobCacheHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Notification\IndNotificationHandler;
use Karma\Setting\IndAppSetting;

class JobApplicationStatusHandler
{

    /**
     * @var JobApplicationStatus
     */
    private $jobApplicationStatus;
    /**
     * @var Jobs
     */
    private $jobs;
    /**
     * @var \Karma\Cache\JobCacheHandler
     */
    private $jobCacheHandler;
    /**
     * @var \Karma\Notification\IndNotificationHandler
     */
    private $indNotificationHandler;

    public function __construct(
        JobApplicationStatus $jobApplicationStatus,
        Jobs $jobs,
        JobCacheHandler $jobCacheHandler,
        IndNotificationHandler $indNotificationHandler
    )
    {
        $this->jobApplicationStatus = $jobApplicationStatus;
        $this->jobs = $jobs;
        $this->jobCacheHandler = $jobCacheHandler;
        $this->indNotificationHandler = $indNotificationHandler;
    }

    public function addJobStatus($data)
    {

        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'jobUserId' => 'required',
                'appCopUserId' => 'required',
                'appJobId' => 'required',
                'appId' => 'required',
                'statusName' => 'required'
            ),
            6);

        $userToken = $data->userToken;
        $userId = $data->jobUserId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // check job in job table
        if (!$this->jobs->isJobExists($userId, $data->appJobId)) {
            return false;
        }
        $result=$this->jobApplicationStatus->addApplicationStatus($data->appId,$data->statusName);

        if ($result) {

            $jobs = $this->jobs->selectById($data->appJobId);

            // update cache for job
            $this->jobCacheHandler->make($jobs, $data->appJobId, $userId);

            // add internal log
            CopInternalLogHandler::addInternalLog($userId, $data);

            $jobTitle = Jobs::jobTitleById($data->appJobId);
            $jobTitle = $jobTitle['title'];

            $notificationDetails = 'You are <strong>'.$data->statusName.'</strong> for a job : "<strong>' . $jobTitle . '</strong>"';

            $this->indNotificationHandler->addNotification($data->appCopUserId, $notificationDetails, '_JOB_APPLICATION_STATUS_', $data->appJobId);

            // fire event when job apply. its Notification to cop user form individual user
            if(IndAppSetting::createAppSetting($ff,'jobApplicationStatus'))
//            if (CopAppSetting::isSubscribed($data->appCopUserId, 'jobApplied')) {
//                \Event::fire('job.apply', $application);
//            }

            return Lang::get('messages.job_apply.job_apply_successful');
        }

        return false;
    }
}