<?php
/**
 * User: kishan
 * Date: 9/21/14
 * Time: 9:07 PM
 */

namespace Karma\Users;


class IndUserRepository {
    public function save(IndUser $users)
    {
        return $users->save();
    }
} 