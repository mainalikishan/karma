<?php
/**
 * User: kishan
 * Date: 11/2/14
 * Time: 10:25 AM
 */

namespace Karma\Setting;


class IndAppSetting extends \Eloquent
{
    const CREATED_AT = 'settingAddedDate';
    const UPDATED_AT = 'settingUpdatedDate';
    protected $primaryKey = 'settingId';

    protected $fillable = array(
        'settingUserId',
        'settings'
    );

    // database table used by model
    protected $table = 'ind_app_settings';

    public static function createAppSetting($settingUserId, $settings)
    {
        $appSetting = new static (compact('settingUserId', 'settings'));
        return $appSetting;
    }

    public static function selectAppSettingByUserId($settingUserId)
    {
        $appSetting =
            self::select(array('settingId', 'settingUserId', 'settings'))
                ->where(compact('settingUserId'))
                ->first();
        if ($appSetting) {
            return $appSetting;
        }
        return false;
    }

} 