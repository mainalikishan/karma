<?php
/**
 * User: kishan
 * Date: 9/29/14
 * Time: 1:19 PM
 */

namespace Karma\General;


class Gender extends \Eloquent
{
    const CREATED_AT = 'genderAddedDate';
    const UPDATED_AT = 'genderUpdatedDate';
    protected $primaryKey = 'genderId';

    protected $fillable = array(
        'genderName'
    );

    // database table used by model
    protected $table = 'ind_gender';

    public static function selectName($genderId) {
        $gender = self::select(array('genderName'))
            ->where(compact('genderId'))
            ->first();
        if($gender) {
            return $gender->genderName;
        }
        throw new \Exception(\Lang::get('errors.invalid_gender_id'));
    }

} 