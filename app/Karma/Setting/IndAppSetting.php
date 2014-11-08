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

    protected $table = 'ind_app_settings';


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
        if($appSetting) {
            $key = json_decode($appSetting)->$key;
            if(isset($key))
            {
                return $key;
            }
        }
        return false;
    }

} 