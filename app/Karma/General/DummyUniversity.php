<?php
/**
 * User: kishan
 * Date: 10/20/14
 * Time: 9:21 PM
 */

namespace Karma\General;


class DummyUniversity extends \Eloquent
{
    const CREATED_AT = 'universityAddedDate';
    const UPDATED_AT = 'universityUpdatedDate';
    protected $primaryKey = 'universityId';

    protected $fillable = array(
        'universityName'
    );

    protected $table = 'dummy_university';


    /**
     * @param $universityName
     * @return static
     */
    public static function createUniversity($universityName)
    {
        $universityName = ucwords($universityName);
        $dummyUniversity = new static (compact('universityName'));
        return $dummyUniversity;
    }


    /**
     * @param $universityId
     * @return mixed
     * @throws \Exception
     */
    public static function selectName($universityId)
    {
        $dummyUniversity = self::select(array('universityName'))
            ->where(compact('universityId'))
            ->first();
        if ($dummyUniversity) {
            return $dummyUniversity->universityName;
        }
        throw new \Exception(\Lang::get('errors.invalid_university_id'));
    }


    /**
     * @param $universityName
     * @return mixed
     */
    public static function registerUniversity($universityName)
    {
        $dummyUniversity = self::select(array('universityName'))
            ->where(compact('universityName'))
            ->first();
        if ($dummyUniversity) {
            return $dummyUniversity->universityName;
        } else {
            $dummyUniversity = self::createUniversity($universityName);
            $dummyUniversity->save();
            return self::registerUniversity($universityName);
        }
    }

} 