<?php
/**
 * User: Prakash
 * Date: 10/10/14
 * Time: 8:52 PM
 */

namespace Karma\Jobs;


class JobsRepository {
    public function save(Jobs $jobs)
    {
        return $jobs->save();
    }
} 