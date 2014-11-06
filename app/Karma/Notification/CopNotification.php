<?php
/**
 * User: Prakash
 * Date: 11/2/14
 * Time: 9:01 AM
 */

namespace Karma\Notification;


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


    /**
     * @param $notificationUserId
     * @param $notificationDetails
     * @param $notificationTargetType
     * @param $notificationTargetId
     * @param $notificationAddedDate
     * @param $notificationUpdatedDate
     * @return static
     */
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

    /**
     * @param $userId
     * @return mixed
     */
    function checkStatus($userId)
    {
        return $notifications = $this->where('notificationUserId', $userId)
            ->where('notificationView', 'N')
            ->get();
    }
} 