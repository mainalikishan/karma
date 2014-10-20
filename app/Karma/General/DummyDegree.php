<?php
/**
 * User: kishan
 * Date: 10/20/14
 * Time: 9:37 PM
 */

namespace Karma\General;


class DummyDegree extends \Eloquent
{
    const CREATED_AT = 'degreeAddedDate';
    const UPDATED_AT = 'degreeUpdatedDate';
    protected $primaryKey = 'degreeId';

    protected $fillable = array(
        'degreeName'
    );

    // database table used by model
    protected $table = 'dummy_degree';

    public static function createDegree($degreeName)
    {
        $degreeName = ucwords($degreeName);
        $dummyDegree = new static (compact('degreeName'));
        return $dummyDegree;
    }

    public static function selectName($universityId)
    {
        $dummyDegree = self::select(array('degreeName'))
            ->where(compact('universityId'))
            ->first();
        if ($dummyDegree) {
            return $dummyDegree->degreeName;
        }
        throw new \Exception(\Lang::get('errors.invalid_university_id'));
    }

    public static function registerDegree($degreeName)
    {
        $dummyDegree = self::select(array('degreeName'))
            ->where(compact('degreeName'))
            ->first();
        if ($dummyDegree) {
            return $dummyDegree->degreeName;
        } else {
            $dummyDegree = self::createDegree($degreeName);
            $dummyDegree->save();
            return self::registerDegree($degreeName);
        }
    }

} 