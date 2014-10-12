<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 2:27 PM
 */

namespace Karma\Cache;


class IndUserCache extends \Eloquent
{
    const CREATED_AT = 'cacheAddedDate';
    const UPDATED_AT = 'cacheUpdatedDate';
    protected $primaryKey = 'cacheId';

    protected $fillable = array(
        'cacheUserId',
        'cacheValue'
    );

    // database table used by model
    protected $table = 'ind_user_cache';

    public function createCache()
    {
        $args = func_get_args();
        $c = array_combine($this->fillable, $args);
        $cache = new static ($c);
        return $cache;
    }

    public function isCached($cacheUserId)
    {
        $cache = $this->where(compact('cacheUserId'))->first();
        if ($cache) {
            return $cache;
        }
        return false;
    }

    public function selectCacheValue($userId)
    {
        $select = $this
            ->select(array('cacheValue'))
            ->where('cacheUserId', '=', $userId)
            ->first();
        return json_decode($select->cacheValue);
    }
} 