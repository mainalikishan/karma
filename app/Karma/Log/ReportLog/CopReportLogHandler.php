<?php
/**
 * User: Prakash
 * Date: 11/04/14
 * Time: 7:41 AM
 */

namespace Karma\Log\ReportLog;


use Carbon\Carbon;
use Karma\Cache\CopUserCacheHandler;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Users\CopUser;
use Karma\Users\IndUser;

class CopReportLogHandler
{
    /**
     * @var CopReportLog
     */
    private $copReportLog;
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var \Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;

    /**
     * @param CopReportLog $copReportLog
     * @param CopUser $copUser
     * @param CopUserCacheHandler $copUserCacheHandler
     */
    function __construct(CopReportLog $copReportLog,
                         CopUser $copUser,
                         CopUserCacheHandler $copUserCacheHandler)
    {
        $this->copReportLog = $copReportLog;
        $this->copUser = $copUser;
        $this->copUserCacheHandler = $copUserCacheHandler;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addReportLog($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'userId' => 'required',
                'logReportById' => 'required',
                'logUserType' => 'required|string',
                'logText' => 'required|string'
            ),
            5);

        //getting post value
        $userId = $data->userId;
        $logReportById = $data->logReportById;
        $userToken = $data->userToken;
        $type = $data->logUserType;


        if ($type == 'indUser') {
            //checking for valid token id and user id
            IndUser::loginCheck($userToken, $logReportById);

            if ($this->copReportLog->isReport($userId, $logReportById, 'ind') < 1) {

                //update report count in table
                $this->copUser->updateReport($userId);

                // add internal log
                CopInternalLogHandler::addInternalLog($logReportById, $data);

                //add report log
                CopReportLog::create(array(
                    'logUserId' => $userId,
                    'logReportById' => $logReportById,
                    'logText' => $data->logText,
                    'logUserType' => 'ind',
                    'logAddedDate' => Carbon::now(),
                    'logUpdatedDate' => Carbon::now()
                ));

                return \Lang::get('messages.profile.received_report');
            }
            return \Lang::get('errors.profile.already_reported');
        } else if ($type == 'copUser') {
            //checking for valid token id and user id
            \CopUserLoginCheck::loginCheck($userToken, $logReportById);

            if ($this->copReportLog->isReport($userId, $logReportById, 'cop') < 1) {

                //update report count in table
                $this->copUser->updateReport($userId);

                //add report log
                CopReportLog::create(array(
                    'logUserId' => $userId,
                    'logReportById' => $logReportById,
                    'logText' => $data->logText,
                    'logUserType' => 'cop',
                    'logAddedDate' => Carbon::now(),
                    'logUpdatedDate' => Carbon::now()
                ));
                return \Lang::get('messages.profile.received_report');
            }
            return \Lang::get('errors.profile.already_reported');
        }

        return \Lang::get('errors.something_went_wrong');
    }

} 