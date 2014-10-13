<?php
/**
 * User: Prakash
 * Date: 10/13/14
 * Time: 8:40 PM
 */

namespace Karma\Log\IndActivityLog;


class IndActivityLog extends \Eloquent
{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId', 'logDetails'];

    //database table ind_user_activity_log
    protected $table = 'ind_user_activity_log';
}