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
    protected $primaryKey = 'idCountry';

    protected $fillable = array(
        'countryName',
        'countryCode'
    );

    protected $table = 'country';


    /**
     * @return mixed
     */
    public static function selectCountryAll()
    {
        return
            self::select(array('countryCode', 'countryName'))
            ->get();
    }


    /**
     * @return mixed
     */
    public static function selectCurrencyAll()
    {
        return
            self::select(array('currencyCode'))
            ->get();
    }

    /**
     * @param $countryCode
     * @return bool
     */
    public static function selectCountryNameByISO($countryCode) {
        $countryCode = strtoupper($countryCode);
        $country = self::select(array('idCountry', 'countryCode', 'countryName'))
            ->where(compact('countryCode'))
            ->first();
        if($country) {
            return $country;
        }
        return false;
    }

}