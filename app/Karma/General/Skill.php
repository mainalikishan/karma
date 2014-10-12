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

    // database table used by model
    protected $table = 'skill';

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