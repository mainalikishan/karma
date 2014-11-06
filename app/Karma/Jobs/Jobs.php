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

    protected $fillable = ['jobUserId',
        'jobTitle',
        'jobTypeId',
        'jobOpen',
        'jobCountryId',
        'jobAddressId',
        'jobSkills',
        'jobExpDate',
        'jobExp'];


    /**
     * @param $jobId
     * @return mixed
     */
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

    /**
     * @param $copUserId
     * @param $jobId
     * @return mixed
     */
    public function isJobExists($copUserId, $jobId)
    {
        return $this->where('jobUserId', $copUserId)
            ->where('jobId', $jobId)
            ->count();
    }

    /**
     * @param $copUserId
     * @param $jobId
     * @return mixed
     */
    public function updateApplyCount($copUserId, $jobId)
    {
        return $job = $this->where('jobUserId', $copUserId)
            ->where('jobId', $jobId)
            ->first();
    }

    /**
     * @param $jobId
     * @return array|bool
     */
    public static function jobTitleById($jobId)
    {
        $job = self::select('jobTitle', 'jobSummary')
            ->where('jobId', $jobId)
            ->first();
        if ($job) {
            return array("title" => $job->jobTitle, 'summary' => $job->jobSummary);
        } else {
            return false;
        }
    }
} 