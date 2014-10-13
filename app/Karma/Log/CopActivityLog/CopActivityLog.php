<?php
/**
 * User: Prakash
 * Date: 10/12/14
 * Time: 8:03 PM
 */

namespace Karma\Log\CopActivityLog;


class CopActivityLog extends \Eloquent
{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId', 'logDetails'];

    //database table cop_activity_log
    protected $table = 'cop_activity_log';
}