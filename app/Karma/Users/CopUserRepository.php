<?php
/**
 * User: Prakash
 * Date: 9/20/14
 * Time: 8:58 PM
 */

namespace Karma\Users;


class CopUserRepository {

    public function save(CopUser $users)
    {
        return $users->save();
    }

} 