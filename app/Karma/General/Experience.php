<?php
/**
 * User: kishan
 * Date: 10/17/14
 * Time: 9:51 PM
 */

namespace Karma\General;


class Experience extends \Eloquent
{
    const CREATED_AT = 'expAddedDate';
    const UPDATED_AT = 'expUpdatedDate';

    protected $primaryKey = 'expId';
    protected $guarded = array('expId');

    protected $fillable = array(
        'expUserId',
        'expTitle',
        'expType',
        'expCompany',
        'expCurrent',
        'expStartDate',
        'expEndDate'
    );

    protected $table = 'ind_experience';


    /**
     * @param $expUserId
     * @param $expTitle
     * @param $expType
     * @param $expCompany
     * @param $expCurrent
     * @param $expStartDate
     * @param $expEndDate
     * @return static
     */
    public static function createExp($expUserId, $expTitle, $expType, $expCompany, $expCurrent, $expStartDate, $expEndDate)
    {
        $experience = new static (compact('expUserId', 'expTitle', 'expType', 'expCompany', 'expCurrent', 'expStartDate', 'expEndDate'));
        return $experience;
    }


    /**
     * @param $expId
     * @param $expUserId
     * @return bool
     */
    public static function selectExp($expId, $expUserId)
    {
        $experience = self::where(compact('expId', 'expUserId'))
            ->first();
        if ($experience) {
            return $experience;
        }
        return false;
    }

} 