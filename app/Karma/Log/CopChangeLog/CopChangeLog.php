<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 1:55 PM
 */

namespace Karma\Log\CopChangeLog;


class CopChangeLog  extends \Eloquent{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT  = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId','logKey', 'logValue'];

    //database table copChangeLog
    protected $table = 'cop_change_log';
} 