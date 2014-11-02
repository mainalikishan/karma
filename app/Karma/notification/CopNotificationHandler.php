<?php
/**
 * User: Prakash
 * Date: 11/2/14
 * Time: 9:56 AM
 */

namespace Karma\notification;

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
}