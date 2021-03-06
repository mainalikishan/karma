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

    protected $table = 'cop_app_settings';


    /**
     * @param $settingUserId
     * @param $settings
     * @return static
     */
    public static function createAppSetting($settingUserId, $settings)
    {
        $appSetting = new static (compact('settingUserId', 'settings'));
        return $appSetting;
    }


    /**
     * @param $settingUserId
     * @return bool
     */
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

    /**
     * @param $settingUserId
     * @param $key
     * @return bool
     */
    public static function isSubscribed($settingUserId, $key)
    {
        $appSetting =
            self::selectAppSettingByUserId($settingUserId);
        if ($appSetting) {
            $notification = json_decode($appSetting->settings)->notification;
            foreach ($notification as $k)
            {
                if (isset($k->$key)) {
                    return $k->$key=='true'?true:false;
                }
            }
        }
        return false;
    }

} 