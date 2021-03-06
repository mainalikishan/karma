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

    protected $table = 'ind_gender';


    /**
     * @param $genderName
     * @return static
     */
    public static function createGender($genderName)
    {
        $gender = new static (compact('genderName'));
        return $gender;
    }

    /**
     * @param $genderId
     * @return mixed
     * @throws \Exception
     */
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