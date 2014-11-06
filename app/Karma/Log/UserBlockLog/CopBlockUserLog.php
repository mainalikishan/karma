<?php
/**
 * User: Prakash
 * Date: 11/04/14
 * Time: 7:36 AM
 */

namespace Karma\Log\UserBlockLog;


class CopBlockUserLog extends \Eloquent
{

    const CREATED_AT = 'blockAddedDate';
    const UPDATED_AT = 'blockUpdatedDate';

    protected $primaryKey = 'blockId';

    protected $fillable = ['blockUserId', 'blockByUserId', 'blockUserType', 'blockStatus'];

    //database table cop_block_user
    protected $table = 'cop_block_user';


    /**
     * @param $blockUserId
     * @param $blockByUserId
     * @param $type
     * @return mixed
     */
    public function isBlock($blockUserId, $blockByUserId, $type)
    {
        return $user = $this->where('blockUserId', $blockUserId)
            ->where('blockByUserId', $blockByUserId)
            ->where('blockUserType', $type)
            ->where('blockStatus', 'Y')
            ->count();
    }

    /**
     * @param $blockUserId
     * @param $blockByUserId
     * @param $type
     * @return mixed
     */
    public function getRecord($blockUserId, $blockByUserId, $type)
    {
        return $user = $this->where('blockUserId', $blockUserId)
            ->where('blockByUserId', $blockByUserId)
            ->where('blockUserType', $type)
            ->where('blockStatus', 'Y')
            ->first();
    }
}