<?php
/**
 * User: Prakash
 * Date: 10/12/14
 * Time: 8:03 PM
 */

namespace Karma\Log\CopInternalLog;


class CopInternalLog  extends \Eloquent{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT  = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId','logDetails'];

    //database table cop_internal_log
    protected $table = 'cop_internal_log';
}