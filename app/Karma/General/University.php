<?php
/**
 * User: kishan
 * Date: 10/19/14
 * Time: 9:28 PM
 */

namespace Karma\General;


class University extends \Eloquent
{
    const CREATED_AT = 'universityAddedDate';
    const UPDATED_AT = 'universityUpdatedDate';
    protected $primaryKey = 'universityId';

    protected $fillable = array(
        'universityName'
    );

    protected $table = 'university';


    /**
     * @param $universityId
     * @return mixed
     * @throws \Exception
     */
    public static function selectName($universityId) {
        $university = self::select(array('universityName'))
            ->where(compact('universityId'))
            ->first();
        if($university) {
            return $university->universityName;
        }
        throw new \Exception(\Lang::get('errors.invalid_university_id'));
    }

} 