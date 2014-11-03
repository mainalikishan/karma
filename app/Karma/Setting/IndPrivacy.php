<?php
/**
 * User: kishan
 * Date: 11/2/14
 * Time: 4:03 PM
 */

namespace Karma\Setting;


class IndPrivacy extends \Eloquent
{
    const CREATED_AT = 'privacyAddedDate';
    const UPDATED_AT = 'privacyUpdatedDate';
    protected $primaryKey = 'privacyId';

    protected $fillable = array(
        'privacyUserId',
        'privacyData'
    );

    // database table used by model
    protected $table = 'ind_privacy';

    public static function createPrivacy($privacyUserId, $privacyData)
    {
        $privacy = new static (compact('privacyUserId', 'privacyData'));
        return $privacy;
    }

    public static function selectPrivacyByUserId($privacyUserId)
    {
        $privacy =
            self::select(array('privacyId', 'privacyUserId', 'privacyData'))
                ->where(compact('privacyUserId'))
                ->first();
        if ($privacy) {
            return $privacy;
        }
        return false;
    }

} 