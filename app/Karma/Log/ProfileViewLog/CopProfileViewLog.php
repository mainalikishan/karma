<?php
/**
 * User: Prakash
 * Date: 11/03/14
 * Time: 8:40 PM
 */

namespace Karma\Log\ProfileViewLog;


class CopProfileViewLog  extends \Eloquent{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT  = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logViewerId', 'logUserId', 'logUserType'];

    //database table cop_profile_view_log
    protected $table = 'cop_profile_view_log';
}