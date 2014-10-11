<?php
/**
 * User: kishan
 * Date: 9/29/14
 * Time: 2:12 PM
 */

namespace Karma\General;


class Country  extends \Eloquent
{
    const CREATED_AT = 'countryAddedDate';
    const UPDATED_AT = 'countryUpdatedDate';
    protected $primaryKey = 'countryId';

    protected $fillable = array(
        'countryName',
        'countryISOCode'
    );

    // database table used by model
    protected $table = 'country';

    public static function selectCountryNameByISO($countryISOCode) {
        $country = self::select(array('countryId', 'countryName'))
            ->where(compact('countryISOCode'))
            ->first();
        if($country) {
            return $country;
        }
        return false;
    }

}