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

    protected $table = 'ind_education';


    /**
     * @param $eduUserId
     * @param $eduUniversityId
     * @param $eduDegreeId
     * @param $eduPassedYear
     * @return static
     */
    public static function createEdu($eduUserId, $eduUniversityId, $eduDegreeId, $eduPassedYear)
    {
        $education = new static (compact('eduUserId', 'eduUniversityId', 'eduDegreeId', 'eduPassedYear'));
        return $education;
    }


    /**
     * @param $eduId
     * @param $eduUserId
     * @return bool
     */
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