<?php
/**
 * User: Prakash
 * Date: 11/03/14
 * Time: 9:15 PM
 */

namespace Karma\Log\ProfileViewLog;


class IndProfileViewLog  extends \Eloquent{

    const CREATED_AT = 'logAddedDate';
    const UPDATED_AT  = 'logUpdatedDate';

    protected $primaryKey = 'logId';

    protected $fillable = ['logViewerId', 'logUserId', 'logUserType'];

    //database table ind_profile_view_log
    protected $table = 'ind_profile_view_log';
}