<?php
/**
 * User: Prakash
 * Date: 10/29/14
 * Time: 8:53 PM
 */

namespace Karma\Jobs;


use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Karma\Cache\JobCacheHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\notification\CopNotificationHandler;
use Karma\Users\IndUser;
use Karma\Setting\CopAppSetting;

class JobApplicationHandler
{

    /**
     * @var JobApplication
     */
    private $jobApplication;
    /**
     * @var Jobs
     */
    private $jobs;
    /**
     * @var \Karma\Cache\JobCacheHandler
     */
    private $jobCacheHandler;
    /**
     * @var \Karma\notification\CopNotificationHandler
     */
    private $copNotificationHandler;
    /**
     * @var JobApplicationStatus
     */
    private $jobApplicationStatus;


    /**
     * @param JobApplication $jobApplication
     * @param Jobs $jobs
     * @param JobCacheHandler $jobCacheHandler
     * @param CopNotificationHandler $copNotificationHandler
     * @param JobApplicationStatus $jobApplicationStatus
     */
    function __construct(
        JobApplication $jobApplication,
        Jobs $jobs,
        JobCacheHandler $jobCacheHandler,
        CopNotificationHandler $copNotificationHandler,
        JobApplicationStatus $jobApplicationStatus
    )
    {
        $this->jobApplication = $jobApplication;
        $this->jobs = $jobs;
        $this->jobCacheHandler = $jobCacheHandler;
        $this->copNotificationHandler = $copNotificationHandler;
        $this->jobApplicationStatus = $jobApplicationStatus;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function apply($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'userId' => 'required', //ind  user id
                'appCopUserId' => 'required',
                'appJobId' => 'required'
            ),
            4);

        $userToken = $data->userToken;
        $userId = $data->userId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // check job in job table
        if (!$this->jobs->isJobExists($data->appCopUserId, $data->appJobId)) {
            return false;
        }

        //apply check
        if ($this->isApplied($data->appJobId, $data->appCopUserId, $userId)) {
            return false;
        }

        // add job application if token id and user id is valid
        $application = $this->jobApplication;

        $application->appIndUserId = $userId;
        $application->appCopUserId = $data->appCopUserId;
        $application->appJobId = $data->appJobId;
        $application->appAddedDate = Carbon::now();
        ///save
        $result = $application->save();

        //last inserted id
        $applicationId = $application->appId;

        if ($result) {

            //update job count in job table
            $job = $this->jobs->updateApplyCount($data->appCopUserId, $data->appJobId);
            $job->jobAppCount = $job->jobAppCount + 1;
            $job->jobId = $job->jobId;
            $job->save();

            $jobs = $this->jobs->selectById($data->appJobId);

            //add application status to application status table
            $this->jobApplicationStatus->addApplicationStatus($applicationId, 'Applied');

            // update cache for job
            $this->jobCacheHandler->make($jobs, $data->appJobId, $data->appCopUserId);

            // add internal log
            CopInternalLogHandler::addInternalLog($userId, $data);

            // add Notification
            $indUser = IndUser::selectNameEmail($userId);
            $jobTitle = Jobs::jobTitleById($data->appJobId);
            $jobTitle = $jobTitle['title'];

            $notificationDetails = '<strong>' . $indUser['name'] . '</strong> applied on you job: "' . $jobTitle . '"';

            $this->copNotificationHandler->addNotification($data->appCopUserId, $notificationDetails, '_JOB_APPLY_', $data->appJobId);

            // fire event when job apply. its Notification to cop user form individual user
            if (CopAppSetting::isSubscribed($data->appCopUserId, 'jobApplied')) {
                \Event::fire('job.apply', $application);
            }

            return Lang::get('messages.job_apply.job_apply_successful');
        }

        throw new \Exception(Lang::get('errors.something_went_wrong'));
    }


    /**
     * @param $jobId
     * @param $copUserId
     * @param $indUserId
     * @return mixed
     */
    private function isApplied($jobId, $copUserId, $indUserId)
    {
        $result = $this->jobApplication
            ->where('appJobId', '=', $jobId)
            ->where('appCopUserId', '=', $copUserId)
            ->where('appIndUserId', '=', $indUserId)
            ->first();
        if ($result)
            return true;
        else
            return false;
    }
}