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
                'userId' => 'required', //ind user id
                'indUserId' => 'required',
                'appJobId' => 'required',
                'appId' => 'required',
                'statusName' => 'required'
            ),
            6);

        $userToken = $data->userToken;
        $userId = $data->userId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        // check job in job table
        if (!$this->jobs->isJobExists($userId, $data->appJobId)) {
            return false;
        }
        $result = $this->jobApplicationStatus->addApplicationStatus($data->appId, $data->statusName);

        if ($result) {

            // add internal log
            CopInternalLogHandler::addInternalLog($userId, $data);

            $jobTitle = Jobs::jobTitleById($data->appJobId);
            $jobTitle = $jobTitle['title'];

            $status = Lang::get('keys.applications_status.' . $data->statusName);

            $notificationDetails = 'You are <strong>' . $status . '</strong> for a job : "<strong>' . $jobTitle . '</strong>"';

            $this->indNotificationHandler->addNotification($data->indUserId, $notificationDetails, '_JOB_APPLICATION_STATUS_', $data->appJobId);

            // fire event when application status changed(added) by cop users
            if (IndAppSetting::createAppSetting($data->indUserId, 'jobApplicationStatus')) {
                \Event::fire('application.changeStatus', $data);
            }

            return true;
        }

        return false;
    }
}