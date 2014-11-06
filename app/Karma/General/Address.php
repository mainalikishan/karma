<?php
/**
 * User: kishan
 * Date: 9/29/14
 * Time: 2:21 PM
 */

namespace Karma\General;


class Address extends \Eloquent
{
    const CREATED_AT = 'addressAddedDate';
    const UPDATED_AT = 'addressUpdatedDate';
    protected $primaryKey = 'addressId';

    protected $fillable = array(
        'addressCountryISO',
        'addressName',
        'addressCoordinate',
        'addressTimeZone'
    );

    protected $table = 'address';


    /**
     * @param $addressCountryISO
     * @param $addressName
     * @param $addressCoordinate
     * @param $addressTimeZone
     * @return static
     */
    public static function createAddress($addressCountryISO, $addressName, $addressCoordinate, $addressTimeZone)
    {
        $address = new static (compact('addressCountryISO', 'addressName', 'addressCoordinate', 'addressTimeZone'));
        return $address;
    }


    /**
     * @param $addressId
     * @return bool
     */
    public static function selectAddress($addressId)
    {
        $address = self::select(array('addressName', 'addressCoordinate', 'addressTimeZone'))
            ->where(compact('addressId'))
            ->first();
        if ($address) {
            return $address;
        }
        return false;
    }


    /**
     * @param $data
     * @param $country
     * @return Address
     */
    public static function makeAddress($data, $country)
    {
        $address = self::select(array('addressId', 'addressCountryISO'))
            ->where('addressName', '=', $data->name)->first();
        if ($address) {
            return $address;
        } else {
            $address = self::createAddress($country, $data->name, $data->coordinate, $data->timezone);
            $address->save();
            return self::makeAddress($data, $country);
        }
    }

}