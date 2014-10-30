<?php
/**
 * User: Prakash
 * Date: 10/10/14
 * Time: 8:42 PM
 */

namespace Karma\Jobs;


class Jobs extends \Eloquent
{

    const CREATED_AT = 'jobAddedDate';
    const UPDATED_AT = 'jobUpdatedDate';
    protected $primaryKey = 'jobId';

    //database table used
    protected $table = 'job';

    protected $fillable = ['jobUserId', 'jobTitle', 'jobTypeId', 'jobOpen', 'jobCountryId', 'jobAddressId', 'jobSkills', 'jobExpDate', 'jobExp'];


    public function selectById($jobId)
    {
        return $this->select(array(
            'jobId',
            'jobUserId',
            'jobProfessionId',
            'jobCountryISO',
            'jobAddressId',
            'jobTypeId',
            'jobTitle',
            'jobOpen',
            'jobSkills',
            'jobSummary',
            'jobExp',
            'jobAddedDate',
            'jobExpDate',
            'jobViewCount',
            'jobAppCount',
            'jobShortListCount',
            'jobHireCount',
            'jobRejectCount',
            'jobDelete'
        ))
            ->where('jobId', '=', $jobId)
            ->first();
    }

    public function isJobExists($copUserId, $jobId)
    {
        return $this->where('jobUserId', $copUserId)
            ->where('jobId', $jobId)
            ->count();
    }

    public function updateApplyCount($copUserId, $jobId)
    {
        return $job = $this->where('jobUserId', $copUserId)
            ->where('jobId', $jobId)
            ->first();
    }

    public static function jobTitleById($jobId)
    {
        $job = self::select('jobTitle')
            ->where('jobId', $jobId)
            ->first();
        return $job->jobTitle;
    }
} 