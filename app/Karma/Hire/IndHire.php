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
        'hireRequest',
        'hireRequestDate',
        'hireAccept',
        'hireAcceptDate'
    ];


    /**
     * @param $hireById
     * @param $hireToId
     * @param $hireByUserType
     * @param $hireRequest
     * @param $hireRequestDate
     * @return static
     */
    public function createHire($hireById, $hireToId, $hireByUserType, $hireRequest, $hireRequestDate)
    {
        $hire = new static (compact('hireById', 'hireToId', 'hireByUserType', 'hireRequest', 'hireRequestDate'));
        return $hire;
    }


    /**
     * @param $hireById
     * @param $hireToId
     * @param $hireByUserType
     * @return bool
     */
    public function isHired($hireById, $hireToId, $hireByUserType)
    {
        $hire =
            $this->select('hireId', 'hireById', 'hireToId', 'hireByUserType', 'hireRequest', 'hireResponse', 'hireResponseDate')
            ->where('hireById', $hireById)
            ->where('hireToId', $hireToId)
            ->where('hireByUserType', $hireByUserType)
            ->where('hireResponse', 'Accept')
            ->first();
        if($hire) {
            return $hire;
        }
        else {
            return false;
        }
    }


    /**
     * @param $hireById
     * @param $hireToId
     * @param $hireByUserType
     * @return bool
     */
    public function checkHireById($hireById, $hireToId, $hireByUserType)
    {
        $hire =
            $this->select('hireId', 'hireById', 'hireToId', 'hireByUserType', 'hireRequest', 'hireResponse', 'hireResponseDate')
                ->where('hireById', $hireById)
                ->where('hireToId', $hireToId)
                ->where('hireByUserType', $hireByUserType)
                ->first();
        if($hire) {
            return $hire;
        }
        else {
            return false;
        }
    }
} 