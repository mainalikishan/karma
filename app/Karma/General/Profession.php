<?php
/**
 * User: kishan
 * Date: 10/12/14
 * Time: 11:57 PM
 */

namespace Karma\General;


class Profession extends \Eloquent
{
    const CREATED_AT = 'professionAddedDate';
    const UPDATED_AT = 'professionUpdatedDate';
    protected $primaryKey = 'professionId';

    protected $fillable = array(
        'professionName'
    );

    // database table used by model
    protected $table = 'profession';

    public static function selectProfessionName($professionId) {
        $profession = self::select(array('professionName'))
            ->where(compact('professionId'))
            ->first();
        if($profession) {
            return $profession->professionName;
        }
        throw new \Exception(\Lang::get('errors.invalid_skill_id'));
    }

} 