<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 1:55 PM
 */

namespace Karma\Log\IndChangeLog;


class IndChangeLog extends \Eloquent
{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId', 'logKey', 'logValue'];

    //database table copChangeLog
    protected $table = 'ind_user_change_log';
} 