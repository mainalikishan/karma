<?php
/**
 * User: Prakash
 * Date: 10/12/14
 * Time: 8:40 PM
 */

namespace Karma\Log\IndInternalLog;


class IndInternalLog  extends \Eloquent{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT  = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logUserId', 'logDetails'];

    //database table ind_internal_log
    protected $table = 'ind_internal_log';
}