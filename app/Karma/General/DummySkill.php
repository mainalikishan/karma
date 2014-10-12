<?php
/**
 * User: kishan
 * Date: 10/12/14
 * Time: 11:35 PM
 */

namespace Karma\General;


class DummySkill extends \Eloquent
{
    const CREATED_AT = 'skillAddedDate';
    const UPDATED_AT = 'skillUpdatedDate';
    protected $primaryKey = 'skillId';

    protected $fillable = array(
        'skillName'
    );

    // database table used by model
    protected $table = 'dummy_skill';

    public static function createSkill($skillName)
    {
        $dummySkill = new static (compact('skillName'));
        return $dummySkill;
    }

    public static function selectSkillName($skillId) {
        $dummySkill = self::select(array('skillName'))
            ->where(compact('skillId'))
            ->first();
        if($dummySkill) {
            return $dummySkill->skillName;
        }
        throw new \Exception(\Lang::get('errors.invalid_skill_id'));
    }

    public static function registerSkill($skillName)
    {
        $dummySkill = self::select(array('skillName'))
            ->where(compact('skillName'))
            ->first();
        if ($dummySkill) {
            return $dummySkill;
        } else {
            $dummySkill = self::createSkill($skillName);
            $dummySkill->save();
            return self::registerSkill($skillName);
        }
    }

} 