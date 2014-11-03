<?php
/**
 * User: kishan
 * Date: 11/2/14
 * Time: 10:12 PM
 */

namespace Karma\Setting;


class CopAppSetting extends \Eloquent
{
    const CREATED_AT = 'settingAddedDate';
    const UPDATED_AT = 'settingUpdatedDate';
    protected $primaryKey = 'settingId';

    protected $fillable = array(
        'settingUserId',
        'settings'
    );

    // database table used by model
    protected $table = 'cop_app_settings';

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