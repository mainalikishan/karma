<?php
/**
 * User: Prakash
 * Date: 11/2/14
 * Time: 11:55 AM
 */

namespace Karma\Notification;


class IndNotification extends \Eloquent
{
    const CREATED_AT = 'notificationAddedDate';
    const UPDATED_AT = 'notificationUpdatedDate';

    protected $primaryKey = 'notificationId';

    protected $fillable =
        array('notificationUserId',
            'notificationDetails',
            'notificationTargetType',
            'notificationTargetId',
            'notificationView'
        );

    //database table ind_notification
    protected $table = 'ind_notification';


    public function createNotification($notificationUserId,
                                       $notificationDetails,
                                       $notificationTargetType,
                                       $notificationTargetId,
                                       $notificationAddedDate,
                                       $notificationUpdatedDate)
    {
        $result = new static (compact('notificationUserId',
            'notificationDetails',
            'notificationTargetType',
            'notificationTargetId',
            'notificationAddedDate',
            'notificationUpdatedDate'));
        return $result;
    }

    function checkStatus($userId)
    {
        return $notifications = $this->where('notificationUserId', $userId)
            ->where('notificationView', 'N')
            ->get();
    }
} 