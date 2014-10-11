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

    // database table used by model
    protected $table = 'address';

    public static function createAddress($addressCountryId, $addressName, $addressCoordinate, $addressTimeZone)
    {
        $address = new static (compact('addressCountryId', 'addressName', 'addressCoordinate', 'addressTimeZone'));
        return $address;
    }

    public static function selectAddress($addressId)
    {
        $address = self::select(array('addressName', 'addressCoordinate', 'addressTimeZone'))
            ->where(compact('addressId'))
            ->first();
        if ($address) {
            return $address;
        }
        throw new \Exception(\Lang::get('errors.invalid_address_id'));
    }

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