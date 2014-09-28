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
    protected $primaryKey  = 'cacheId';

    protected $fillable = array(
        'cacheUserId',
        'cacheValue'
    );

    // database table used by model
    protected $table = 'ind_user_cache';
} 