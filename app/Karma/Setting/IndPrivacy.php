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

    public static function createPrivacy($settingUserId, $settingLangId, $settingNotification)
    {
        $appSetting = new static (compact('settingUserId', 'settingLangId', 'settingNotification'));
        return $appSetting;
    }

    public static function selectPrivacyByUserId($settingUserId)
    {
        $appSetting =
            self::select(array('settingId', 'settingUserId', 'settingLangId', 'settingNotification'))
                ->where(compact('settingUserId'))
                ->first();
        if ($appSetting) {
            return $appSetting;
        }
        return false;
    }

} 