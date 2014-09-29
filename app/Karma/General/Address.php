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
        'addressCountryId',
        'addressName',
        'addressCoordinate'
    );

    // database table used by model
    protected $table = 'address';

    public static function selectAddress($addressId) {
        $address = self::select(array('addressName', 'addressCoordinate'))
            ->where(compact('addressId'))
            ->first();
        if($address) {
            return $address;
        }
        throw new \Exception(\Lang::get('errors.invalid_address_id'));
    }

}