<?php
/**
 * User: Prakash
 * Date: 11/2/14
 * Time: 9:56 AM
 */

namespace Karma\Notification;

use Carbon\Carbon;

class CopNotificationHandler
{


    /**
     * @var CopNotification
     */
    private $copNotification;

    function __construct(CopNotification $copNotification)
    {
        $this->copNotification = $copNotification;
    }

    public function addNotification($userId, $details, $type, $targetId)
    {

        $date = Carbon::now();
        $copNotifications = $this->copNotification->createNotification($userId, $details, $type, $targetId, $date, $date);

        if ($copNotifications) {
            $copNotifications->save();
        }
    }

    public function updateStatus($data)
    {
        // check post array  fields
        \CustomHelper::postCheck($data,
            array('userToken' => 'required',
                'copUserId' => 'required'
            ),
            2);

        $userToken = $data->userToken;
        $userId = $data->copUserId;

        //checking for valid token id and user id
        \CopUserLoginCheck::loginCheck($userToken, $userId);

        $notifications = $this->copNotification->checkStatus($userId);
        foreach ($notifications as $notification) {
            $notification->notificationId = $notification->notificationId;
            $notification->notificationView = 'Y';
            $notification->notificationUpdatedDate = Carbon::now();
            $notification->save();
        }
    }
}