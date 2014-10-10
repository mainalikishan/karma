<?php
/**
 * User: Prakash
 * Date: 10/10/14
 * Time: 8:42 PM
 */

namespace Karma\Jobs;


class Jobs extends \Eloquent{

    const CREATED_AT = 'jobAddedDate';
    const UPDATED_AT = 'jobUpdatedDate';
    protected $primaryKey = 'jobId';

    //database table used
    protected $table = 'job';

    protected $fillable = ['jobUserId', 'jobCountryId', 'jobAddressId', 'jobSkills', 'jobExpDate', 'jobExp'];


} 