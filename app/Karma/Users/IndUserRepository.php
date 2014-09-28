<?php
/**
 * User: kishan
 * Date: 9/21/14
 * Time: 9:07 PM
 */

namespace Karma\Users;


class IndUserRepository {


    /**
     * @var IndUser
     */
    private $indUser;

    function __construct(IndUser $indUser)
    {
        $this->indUser = $indUser;
    }

    public function save($user)
    {
        return $user->save();
    }
} 