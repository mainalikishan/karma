<?php
/**
 * User: kishan
 * Date: 10/12/14
 * Time: 10:49 PM
 */

namespace Karma\General;


class Skill extends \Eloquent
{
    const CREATED_AT = 'skillAddedDate';
    const UPDATED_AT = 'skillUpdatedDate';
    protected $primaryKey = 'skillId';

    protected $fillable = array(
        'skillName'
    );

    protected $table = 'skill';


    /**
     * @param $skillName
     * @return static
     */
    public static function createSkill($skillName)
    {
        $skill = new static (compact('skillName'));
        return $skill;
    }

    /**
     * @param $skillId
     * @return mixed
     * @throws \Exception
     */
    public static function selectSkillName($skillId) {
        $skill = self::select(array('skillName'))
            ->where(compact('skillId'))
            ->first();
        if($skill) {
            return $skill->skillName;
        }
        throw new \Exception(\Lang::get('errors.invalid_skill_id'));
    }

}