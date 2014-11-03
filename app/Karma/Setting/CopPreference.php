<?php
/**
 * User: kishan
 * Date: 11/3/14
 * Time: 10:15 PM
 */

namespace Karma\Setting;


class CopPreference extends \Eloquent
{
    const CREATED_AT = 'preferenceAddedDate';
    const UPDATED_AT = 'preferenceUpdatedDate';
    protected $primaryKey = 'preferenceId';

    protected $fillable = array(
        'preferenceUserId',
        'preferenceData'
    );

    // database table used by model
    protected $table = 'ind_preference';

    public static function createPreference($preferenceUserId, $preferenceData)
    {
        $preference = new static (compact('preferenceUserId', 'preferenceData'));
        return $preference;
    }

    public static function selectPreferenceByUserId($preferenceUserId)
    {
        $preference =
            self::select(array('preferenceId', 'preferenceUserId', 'preferenceData'))
                ->where(compact('preferenceUserId'))
                ->first();
        if ($preference) {
            return $preference;
        }
        return false;
    }

} 