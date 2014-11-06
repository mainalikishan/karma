<?php
/**
 * User: Prakash
 * Date: 11/2/14
 * Time: 12:02 PM
 */

namespace Karma\Notification;

use Carbon\Carbon;

class IndNotificationHandler
{


    /**
     * @var IndNotification
     */
    private $indNotification;

    /**
     * @param IndNotification $indNotification
     */
    function __construct(IndNotification $indNotification)
    {
        $this->indNotification = $indNotification;
    }

    /**
     * @param $userId
     * @param $details
     * @param $type
     * @param $targetId
     */
    public function addNotification($userId, $details, $type, $targetId)
    {

        $date = Carbon::now();
        $indNotifications = $this->indNotification->createNotification($userId, $details, $type, $targetId, $date, $date);

        if ($indNotifications) {
            $indNotifications->save();
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function updateStatus($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'indUserId' => 'required'
            ),
            2);

        $userToken = $data->userToken;
        $userId = $data->indUserId;

        //checking for valid token id and user id

        \ IndUser::loginCheck($userToken, $userId);

        $notifications = $this->indNotification->checkStatus($userId);
        foreach ($notifications as $notification) {
            $notification->notificationId;
            $notification->notificationView = 'Y';
            $notification->notificationUpdatedDate = Carbon::now();
            $notification->save();
        }
        return true;
    }
}