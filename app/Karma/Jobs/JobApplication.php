<?php
/**
 * Created by PhpStorm.
 * User: Prakash
 * Date: 10/29/14
 * Time: 8:40 PM
 */

namespace Karma\Jobs;


class JobApplication extends \Eloquent
{
    public $timestamps = false;
    protected $primaryKey = 'appId';

    //database table used
    protected $table = 'job_app';

    protected $fillable = ['appCopUserId', 'appIndUserId', 'appJobId', 'appAddedDate'];

} 