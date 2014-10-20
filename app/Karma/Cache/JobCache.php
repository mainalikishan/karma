<?php
/**
 * Created by PhpStorm.
 * User: Prakash
 * Date: 10/19/14
 * Time: 8:44 PM
 */

namespace Karma\Cache;


class JobCache extends \Eloquent
{

    const CREATED_AT = 'cacheAddedDate';
    const UPDATED_AT = 'cacheUpdatedDate';
    protected $primaryKey = 'cacheId';

    protected $fillable = array(
        'jobId',
        'userId',
        'cacheDetails'
    );

    // database table used by model
    protected $table = 'job_cache';

    public function createCache()
    {
        $args = func_get_args();
        $c = array_combine($this->fillable, $args);
        $cache = new static ($c);
        return $cache;
    }

    public function isCached($jobId)
    {
        $cache = $this->where(compact('jobId'))->first();
        if ($cache) {
            return $cache;
        }
        return false;
    }

    public function selectCacheValue($jobId)
    {
        $select = $this
            ->select(array('cacheDetails'))
            ->where('jobId', '=', $jobId)
            ->first();
        return json_decode($select->cacheDetails);
    }

    public function selectCacheValueById($userId,$jobId)
    {
        $select = $this
            ->select(array('cacheDetails'))
            ->where('userId', '=', $userId)
            ->where('jobId', '=', $jobId)
            ->first();
        return json_decode($select->cacheDetails);
    }

    public function selectAllCacheValue($userId)
    {
        $select = $this
            ->select(array('cacheDetails'))
            ->where('userId', '=', $userId)
            ->first();
        return json_decode($select->cacheDetails);
    }

} 