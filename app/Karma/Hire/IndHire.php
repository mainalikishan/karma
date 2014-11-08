<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 10:04 AM
 */

namespace Karma\Hire;


/**
 * Class IndHire
 * @package Karma\Hire
 */
class IndHire extends \Eloquent
{
    const CREATED_AT = 'hireAddedDate';
    const UPDATED_AT = 'hireUpdatedDate';

    protected $primaryKey = 'hireId';

    protected $table = 'ind_hire';

    protected $fillable = [
        'hireById',
        'hireToId',
        'hireByUserType',
        'hireAccept',
        'hireAcceptDate'
    ];

    public static function createHire($hireById, $hireToId, $hireByUserType, $hireAccept, $hireAcceptDate)
    {
        $hire = new static (compact('hireById', 'hireToId', 'hireByUserType', 'hireAccept', 'hireAcceptDate'));
        return $hire;
    }

    /**
     * @param $hireById
     * @param $hireToId
     * @param $hireByUserType
     * @return mixed
     */
    public function isHired($hireById, $hireToId, $hireByUserType)
    {
        $hire =
            $this->where('hireById', $hireById)
            ->where('hireToId', $hireToId)
            ->where('hireByUserType', $hireByUserType)
            ->where('hireAccept', 'Y')
            ->first();
        if($hire) {
            return true;
        }
        else {
            return false;
        }
    }
} 