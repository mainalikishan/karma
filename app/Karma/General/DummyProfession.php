<?php
/**
 * User: kishan
 * Date: 10/13/14
 * Time: 8:11 PM
 */

namespace Karma\General;


class DummyProfession extends \Eloquent
{
    const CREATED_AT = 'professionAddedDate';
    const UPDATED_AT = 'professionUpdatedDate';
    protected $primaryKey = 'professionId';

    protected $fillable = array(
        'professionName'
    );

    // database table used by model
    protected $table = 'dummy_profession';

    public static function createProfession($professionName)
    {
        $professionName = ucwords($professionName);
        $dummyProfession = new static (compact('professionName'));
        return $dummyProfession;
    }

    public static function selectProfessionName($skillId)
    {
        $dummyProfession = self::select(array('professionName'))
            ->where(compact('skillId'))
            ->first();
        if ($dummyProfession) {
            return $dummyProfession->skillName;
        }
        throw new \Exception(\Lang::get('errors.invalid_skill_id'));
    }

    public static function registerProfession($professionName)
    {
        $dummyProfession = self::select(array('professionName'))
            ->where(compact('professionName'))
            ->first();
        if ($dummyProfession) {
            return $dummyProfession->professionName;
        } else {
            $dummyProfession = self::createProfession($professionName);
            $dummyProfession->save();
            return self::registerProfession($professionName);
        }
    }

} 