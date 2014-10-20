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

    // database table used by model
    protected $table = 'ind_experience';

    public static function createExp($expUserId, $expTitle, $expType, $expCompany, $expCurrent, $expStartDate, $expEndDate)
    {
        $experience = new static (compact('expUserId', 'expTitle', 'expType', 'expCompany', 'expCurrent', 'expStartDate', 'expEndDate'));
        return $experience;
    }

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