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

    function __construct(IndNotification $indNotification)
    {
        $this->indNotification = $indNotification;
    }

    public function addNotification($userId, $details, $type, $targetId)
    {

        $date = Carbon::now();
        $indNotifications = $this->copNotification->createNotification($userId, $details, $type, $targetId, $date, $date);

        if ($indNotifications) {
            $indNotifications->save();
        }
    }

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

        $notifications = $this->copNotification->checkStatus($userId);
        foreach ($notifications as $notification) {
            $notification->notificationId = $notification->notificationId;
            $notification->notificationView = 'Y';
            $notification->notificationUpdatedDate = Carbon::now();
            $notification->save();
        }
    }
}