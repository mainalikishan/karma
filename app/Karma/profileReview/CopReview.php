<?php
/**
 * User: Prakash
 * Date: 11/7/14
 * Time: 10:33 AM
 */

namespace Karma\profileReview;


class CopReview
{
    const CREATED_AT = 'reviewAddedDate';
    const UPDATED_AT = 'hireAccept';

    protected $primaryKey = 'reviewId';

    //database table ind_hire
    protected $table = 'ind_hire';

    protected $fillable = ['hireById',
        'hireToId',
        'hireByUserType',
        'hireAcceptDate',
        'hireAccept'
    ];

    public function hiredCheck($hireById, $hireToId, $hireByUserType)
    {
        return $user = $this->where('hireById', $hireById)
            ->where('hireToId', $hireToId)
            ->where('hireByUserType', $hireByUserType)
            ->where('hireAccept', 'Y')
            ->count();
    }
} 