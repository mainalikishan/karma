<?php
/**
 * User: Prakash
 * Date: 11/04/14
 * Time: 7:36 AM
 */

namespace Karma\Log\ReportLog;


class IndReportLog extends \Eloquent
{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId', 'logReportById', 'logText', 'logUserType'];

    //database table cop_report_log
    protected $table = 'ind_report_log';


    /**
     * @param $logUserId
     * @param $logReportById
     * @param $type
     * @return mixed
     */
    public function isReport($logUserId, $logReportById, $type)
    {
        return $user = $this->where('logUserId', $logUserId)
            ->where('logReportById', $logReportById)
            ->where('logUserType', $type)
            ->count();
    }
}