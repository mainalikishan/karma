<?php
/**
 * User: Prakash
 * Date: 11/2/14
 * Time: 9:01 AM
 */

namespace Karma\notification;


class CopNotification extends \Eloquent
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

    //database table cop_notification
    protected $table = 'cop_notification';


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
} 