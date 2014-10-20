<?php
/**
 * User: Prakash
 * Date: 10/20/14
 * Time: 8:52 PM
 */

namespace Karma\General;

class JobType extends \Eloquent
{

    public $timestamp = false;
    protected $primaryKey = 'jobTypeId';

    protected $fillable = array(
        'jobTypeName'
    );

    // database table used by model
    protected $table = 'job_type';

    public static function selectJobType($jobTypeId)
    {
        $jobType = self::select(array('jobTypeName'))
            ->where(compact('jobTypeId'))
            ->first();
        if ($jobType) {
            return $jobType->jobTypeName;
        }
        throw new \Exception(\Lang::get('errors.invalid_job_type_id'));
    }

} 