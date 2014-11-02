<?php
/**
 * Created by PhpStorm.
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

    function __construct(JobApplication $jobApplication,
                         Jobs $jobs, JobCacheHandler $jobCacheHandler,
                         CopNotificationHandler $copNotificationHandler)
    {
        $this->jobApplication = $jobApplication;
        $this->jobs = $jobs;
        $this->jobCacheHandler = $jobCacheHandler;
        $this->copNotificationHandler = $copNotificationHandler;
    }

    public function apply($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'jobUserId' => 'required',
                'appCopUserId' => 'required',
                'appJobId' => 'required'
            ),
            4);

        $userToken = $data->userToken;
        $userId = $data->jobUserId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // check job in job table
        if ($this->jobs->isJobExists($data->appCopUserId, $data->appJobId) === 0) {
            return Lang::get('errors.something_went_wrong');
        }

        //apply count
        if ($this->applyCount($data->appJobId, $data->appCopUserId, $userId) > 0) {
            return Lang::get('errors.apply_job.apply_already');
        }

        // add job application if token id and user id is valid
        $application = $this->jobApplication;

        $application->appIndUserId = $userId;
        $application->appCopUserId = $data->appCopUserId;
        $application->appJobId = $data->appJobId;
        $application->appAddedDate = Carbon::now();
        ///save
        $result = $application->save();

        if ($result) {

            //update job count in job table
            $job = $this->jobs->updateApplyCount($data->appCopUserId, $data->appJobId);
            $job->jobAppCount = $job->jobAppCount + 1;
            $job->jobId = $job->jobId;
            $job->save();

            $jobs = $this->jobs->selectById($data->appJobId);

            // update cache for job
            $this->jobCacheHandler->make($jobs, $data->appJobId, $data->appCopUserId);

            // add internal log
            CopInternalLogHandler::addInternalLog($userId, $data);

            // add notification
            $indUser = IndUser::selectNameEmail($userId);
            $jobTitle = Jobs::jobTitleById($data->appJobId);
            $jobTitle=$jobTitle['title'];

            $notificationDetails = '<strong>'.$indUser['name'].'</strong> applied on you job: "'.$jobTitle.'"';

            $this->copNotificationHandler->addNotification($userId, $notificationDetails, '_JOB_APPLY_', $data->appJobId);

            // fire event when job apply. its notification to cop user form individual user
           // \Event::fire('job.apply', $application);

            return Lang::get('messages.job_apply.job_apply_successful');
        }

        throw new \Exception(Lang::get('errors.something_went_wrong'));
    }


    private function applyCount($jobId, $copUserId, $indUserId)
    {
        return $this->jobApplication
            ->where('appJobId', '=', $jobId)
            ->where('appCopUserId', '=', $copUserId)
            ->where('appIndUserId', '=', $indUserId)
            ->count();
    }
}