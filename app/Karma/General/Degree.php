<?php
/**
 * User: kishan
 * Date: 10/20/14
 * Time: 10:29 PM
 */

namespace Karma\General;


class Degree extends \Eloquent
{
    const CREATED_AT = 'degreeAddedDate';
    const UPDATED_AT = 'degreeUpdatedDate';

    protected $primaryKey = 'degreeId';
    protected $guarded = array('degreeId');

    protected $fillable = array(
        'degreeName'
    );

    protected $table = 'degree';


    /**
     * @param $degreeId
     * @return mixed
     * @throws \Exception
     */
    public static function selectName($degreeId)
    {
        $degree = self::select(array('degreeName'))
            ->where(compact('degreeId'))
            ->first();
        if ($degree) {
            return $degree->degreeName;
        }
        throw new \Exception(\Lang::get('errors.invalid_degree_id'));
    }

} 