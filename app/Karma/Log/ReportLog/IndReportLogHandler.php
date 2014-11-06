<?php
/**
 * User: Prakash
 * Date: 11/05/14
 * Time: 7:32 AM
 */

namespace Karma\Log\ReportLog;


use Carbon\Carbon;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\indUser;

class IndReportLogHandler
{
    /**
     * @var IndReportLog
     */
    private $indReportLog;
    /**
     * @var \Karma\Users\IndUser
     */
    private $indUser;


    /**
     * @param IndReportLog $indReportLog
     * @param indUser $indUser
     */
    function __construct(IndReportLog $indReportLog,
                         IndUser $indUser)
    {
        $this->indReportLog = $indReportLog;
        $this->indUser = $indUser;
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

            if ($this->indReportLog->isReport($userId, $logReportById, 'ind') < 1) {

                //update report count in table
                $this->indUser->updateReport($userId);

                // add internal log
                IndInternalLogHandler::addInternalLog($logReportById, $data);

                //add report log
                IndReportLog::create(array(
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

            if ($this->indReportLog->isReport($userId, $logReportById, 'cop') < 1) {

                //update report count in table
                $this->indUser->updateReport($userId);

                // add internal log
                IndInternalLogHandler::addInternalLog($logReportById, $data);

                //add report log
                IndReportLog::create(array(
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