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

    protected $table = 'job_type';
    
    /**
     * @param $jobTypeId
     * @return mixed
     * @throws \Exception
     */
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