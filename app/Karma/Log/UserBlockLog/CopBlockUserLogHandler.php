<?php
/**
 * User: Prakash
 * Date: 11/04/14
 * Time: 7:41 AM
 */

namespace Karma\Log\UserBlockLog;


use Carbon\Carbon;
use Karma\Log\CopInternalLog\CopInternalLogHandler;
use Karma\Users\CopUser;
use Karma\Users\IndUser;

class CopBlockUserLogHandler
{
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var CopBlockUserLog
     */
    private $copBlockUserLog;

    /**
     * @param CopBlockUserLog $copBlockUserLog
     * @param CopUser $copUser
     */
    function __construct(CopBlockUserLog $copBlockUserLog,
                         CopUser $copUser)
    {
        $this->copUser = $copUser;
        $this->copBlockUserLog = $copBlockUserLog;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function addBlockLog($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'userId' => 'required',
                'blockByUserId' => 'required',
                'blockUserType' => 'required|string'
            ),
            4);

        //getting post value
        $userId = $data->userId;
        $blockByUserId = $data->blockByUserId;
        $userToken = $data->userToken;
        $type = $data->blockUserType;


        if ($type == 'indUser') {
            //checking for valid token id and user id
            IndUser::loginCheck($userToken, $blockByUserId);

            if ($this->copBlockUserLog->isBlock($userId, $blockByUserId, 'ind') < 1) {

                // add internal log
                CopInternalLogHandler::addInternalLog($blockByUserId, $data);

                //add report log
                CopBlockUserLog::create(array(
                    'blockUserId' => $userId,
                    'blockByUserId' => $blockByUserId,
                    'blockUserType' => 'ind',
                    'blockAddedDate' => Carbon::now(),
                    'blockUpdatedDate' => Carbon::now()
                ));

                return \Lang::get('messages.profile.block_success');
            }
            return \Lang::get('errors.profile.already_blocked');
        } else if ($type == 'copUser') {
            //checking for valid token id and user id
            \CopUserLoginCheck::loginCheck($userToken, $blockByUserId);

            if ($this->copBlockUserLog->isBlock($userId, $blockByUserId, 'cop') < 1) {

                // add internal log
                CopInternalLogHandler::addInternalLog($blockByUserId, $data);

                //add  log
                CopBlockUserLog::create(array(
                    'blockUserId' => $userId,
                    'blockByUserId' => $blockByUserId,
                    'blockUserType' => 'cop',
                    'blockAddedDate' => Carbon::now(),
                    'blockUpdatedDate' => Carbon::now()
                ));
                return \Lang::get('messages.profile.block_success');
            }
            return \Lang::get('errors.profile.already_blocked');
        }

        return \Lang::get('errors.something_went_wrong');
    }

    /**
     * @param $data
     * @return mixed
     */
    public function updateBlockLog($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'userId' => 'required',
                'blockByUserId' => 'required',
                'blockUserType' => 'required|string'
            ),
            4);

        //getting post value
        $userId = $data->userId;
        $blockByUserId = $data->blockByUserId;
        $userToken = $data->userToken;
        $type = $data->blockUserType;


        if ($type == 'indUser') {
            //checking for valid token id and user id
            IndUser::loginCheck($userToken, $blockByUserId);
            $record = $this->copBlockUserLog->getRecord($userId, $blockByUserId, 'ind');
            if ($record) {

                //add update status
                $record->blockStatus = 'N';
                $record->blockUpdatedDate = Carbon::now();
                $record->save();
                // add internal log
                CopInternalLogHandler::addInternalLog($blockByUserId, $data);

                return \Lang::get('messages.profile.unblock_success');
            }
            return \Lang::get('errors.profile.already_unblocked');
        } else if ($type == 'copUser') {
            //checking for valid token id and user id
            \CopUserLoginCheck::loginCheck($userToken, $blockByUserId);
            $record = $this->copBlockUserLog->getRecord($userId, $blockByUserId, 'cop');
            if ($record) {

                // add internal log
                CopInternalLogHandler::addInternalLog($blockByUserId, $data);

                //add update status
                $record->blockStatus = 'N';
                $record->blockUpdatedDate = Carbon::now();
                $record->save();
                return \Lang::get('messages.profile.unblock_success');
            }
            return \Lang::get('errors.profile.already_unblocked');
        }

        return \Lang::get('errors.something_went_wrong');
    }
}