<?php
/**
 * User: Prakash
 * Date: 11/2/14
 * Time: 12:02 PM
 */

namespace Karma\notification;

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
}