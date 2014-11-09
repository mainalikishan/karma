<?php
/**
 * User: Prakash
 * Date: 11/9/14
 * Time: 11:26 AM
 */

namespace Karma\Jobs;

use Carbon\Carbon;

class JobApplicationStatus extends \Eloquent
{
    const CREATED_AT = 'statusAddedDate';
    const UPDATED_AT = 'statusUpdatedDate';
    protected $primaryKey = 'statusId';

    //database table used
    protected $table = 'job_app_status';

    protected $fillable = ['statusAppId',
        'statusCurrent',
        'statusName'
    ];

    private function checkStatus($appId, $status)
    {
        $result = $this->where('statusAppId', $appId)
            ->where('statusName', $status)
            ->where('statusCurrent', 'Y')
            ->count();
        if ($result == 0)
            return true;
        else
            return false;
    }

    private function updatePreviousCurrentStatus($appId)
    {
        $results = $this->where('statusAppId', $appId)
            ->where('statusCurrent', 'Y')
            ->get();

        foreach ($results as $res) {
            $res->statusCurrent = 'N';
            $res->statusUpdatedDate = Carbon::now();
            $res->save();
        }
    }

    public function addApplicationStatus($appId, $status)
    {
        $result = $this->checkStatus($appId, $status);
        if ($result) {
            //update status as no current status
            $this->updatePreviousCurrentStatus($appId);
            //add new status
            JobApplicationStatus::create(array('statusAppId' => $appId,
                'statusName' => $status,
                'statusCurrent' => 'Y',
                'statusAddedDate' => Carbon::now(),
                'statusUpdatedDate' => Carbon::now()
            ));
            return true;
        }
        return false;

    }
} 