<?php
/**
 * User: Prakash
 * Date: 11/04/14
 * Time: 7:41 AM
 */

namespace Karma\Log\UserBlockLog;


use Carbon\Carbon;
use Karma\Log\IndInternalLog\IndInternalLogHandler;
use Karma\Users\CopUser;
use Karma\Users\IndUser;

class IndBlockUserLogHandler
{
    /**
     * @var \Karma\Users\CopUser
     */
    private $copUser;
    /**
     * @var IndBlockUserLog
     */
    private $indBlockUserLog;
    function __construct(IndBlockUserLog $indBlockUserLog,
                         CopUser $copUser)
    {
        $this->copUser = $copUser;
        $this->indBlockUserLog = $indBlockUserLog;
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

            if ($this->indBlockUserLog->isBlock($userId, $blockByUserId, 'ind') < 1) {

                // add internal log
                IndInternalLogHandler::addInternalLog($blockByUserId, $data);

                //add report log
                IndBlockUserLog::create(array(
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

            if ($this->indBlockUserLog->isBlock($userId, $blockByUserId, 'cop') < 1) {

                // add internal log
                IndInternalLogHandler::addInternalLog($blockByUserId, $data);

                //add  log
                IndBlockUserLog::create(array(
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
            $record = $this->indBlockUserLog->getRecord($userId, $blockByUserId, 'ind');
            if ($record) {

                //add update status
                $record->blockStatus = 'N';
                $record->blockUpdatedDate = Carbon::now();
                $record->save();
                // add internal log
                IndInternalLogHandler::addInternalLog($blockByUserId, $data);

                return \Lang::get('messages.profile.unblock_success');
            }
            return \Lang::get('errors.profile.already_unblocked');
        } else if ($type == 'copUser') {
            //checking for valid token id and user id
            \CopUserLoginCheck::loginCheck($userToken, $blockByUserId);
            $record = $this->indBlockUserLog->getRecord($userId, $blockByUserId, 'cop');
            if ($record) {

                // add internal log
                IndInternalLogHandler::addInternalLog($blockByUserId, $data);

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