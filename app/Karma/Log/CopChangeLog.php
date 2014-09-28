<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 1:55 PM
 */

namespace Karma\Log;


class CopChangeLog  extends \Eloquent{

    const CREATED_AT = 'logAddedDate';
    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId','logKey', 'logValue'];

    //database table copChangeLog
    protected $table = 'cop_change_log';

    public static function addChangeLog($logUserId,$logKey, $logValue)
    {
        $log = new static (compact('logUserId','logKey', 'logValue'));
        return $log;
    }

} 