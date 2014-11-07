<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 1:20 PM
 */

namespace Karma\Profile\Review;


class IndReviewReport extends \Eloquent
{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    //database table ind_review_report_log
    protected $table = 'ind_review_report_log';

    protected $fillable = ['logReviewId',
        'logReportById',
        'logUserType',
        'logReportText'
    ];

    public function reportCheck($logReviewId, $logReportById, $type)
    {
        return $user = $this->where('logReviewId', $logReviewId)
            ->where('logReportById', $logReportById)
            ->where('logUserType', $type)
            ->count();
    }

} 