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
class IndHire
{
    const CREATED_AT = 'hireDate';
    const UPDATED_AT = 'hireUpdatedDate';

    protected $primaryKey = 'hireId';

    //database table ind_hire
    protected $table = 'ind_hire';

    protected $fillable = ['hireById',
        'hireToId',
        'hireByUserType',
        'hireAcceptDate',
        'hireAccept'
    ];

    /**
     * @param $hireById
     * @param $hireToId
     * @param $hireByUserType
     * @return mixed
     */
    public function hiredCheck($hireById,$hireToId,$hireByUserType)
    {
        return $user = $this->where('hireById', $hireById)
            ->where('hireToId', $hireToId)
            ->where('hireByUserType', $hireByUserType)
            ->where('hireAccept', 'Y')
            ->count();
   }
} 