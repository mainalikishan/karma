<?php
/**
 * User: kishan
 * Date: 10/20/14
 * Time: 8:58 PM
 */

namespace Karma\General;


class Education extends \Eloquent
{
    const CREATED_AT = 'eduAddedDate';
    const UPDATED_AT = 'eduUpdatedDate';

    protected $primaryKey = 'eduId';
    protected $guarded = array('eduId');

    protected $fillable = array(
        'eduUserId',
        'eduUniversityId',
        'eduDegreeId',
        'eduPassedYear'
    );

    // database table used by model
    protected $table = 'ind_education';

    public static function createEdu($eduUserId, $eduUniversityId, $eduDegreeId, $eduPassedYear)
    {
        $education = new static (compact('eduUserId', 'eduUniversityId', 'eduDegreeId', 'eduPassedYear'));
        return $education;
    }

    public static function selectEdu($eduId, $eduUserId)
    {
        $education = self::where(compact('eduId', 'eduUserId'))
            ->first();
        if ($education) {
            return $education;
        }
        return false;
    }

} 