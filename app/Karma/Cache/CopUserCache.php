<?php
/**
 * User: Prakash
 * Date: 10/13/14
 * Time: 10:17 PM
 */

namespace Karma\Cache;


class CopUserCache  extends \Eloquent{

    const CREATED_AT = 'cacheAddedDate';
    const UPDATED_AT = 'cacheUpdatedDate';
    protected $primaryKey = 'cacheId';

    protected $fillable = array(
        'cacheUserId',
        'cacheValue'
    );

    protected $table = 'cop_user_cache';


    /**
     * @return static
     */
    public function createCache()
    {
        $args = func_get_args();
        $c = array_combine($this->fillable, $args);
        $cache = new static ($c);
        return $cache;
    }


    /**
     * @param $cacheUserId
     * @return bool
     */
    public function isCached($cacheUserId)
    {
        $cache = $this->where(compact('cacheUserId'))->first();
        if ($cache) {
            return $cache;
        }
        return false;
    }


    /**
     * @param $userId
     * @return mixed
     */
    public function selectCacheValue($userId)
    {
        $select = $this
            ->select(array('cacheValue'))
            ->where('cacheUserId', '=', $userId)
            ->first();
        return json_decode($select->cacheValue);
    }

} 