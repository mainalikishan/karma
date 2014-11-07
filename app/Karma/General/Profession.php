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

    protected $table = 'profession';


    /**
     * @param $professionName
     * @return static
     */
    public static function createProfession($professionName)
    {
        $profession = new static (compact('professionName'));
        return $profession;
    }

    /**
     * @param $professionId
     * @return mixed
     * @throws \Exception
     */
    public static function selectProfessionName($professionId) {
        $profession = self::select(array('professionName'))
            ->where(compact('professionId'))
            ->first();
        if($profession) {
            return $profession->professionName;
        }
        throw new \Exception(\Lang::get('errors.invalid_profession_id'));
    }

} 