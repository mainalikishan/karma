<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 2:10 PM
 */

namespace Karma\Log;


class CopChangeLogHandler {

    /**
     * @var CopChangeLog
     */
    private $changeLog;
    /**
     * @var CopChangeLog
     */
    private $copChangeLog;

    function __construct(CopChangeLog $copChangeLog)
    {

        $this->copChangeLog = $copChangeLog;
    }

    public function addChangeLog()
    {
        $user = CopChangeLog:: getUser($data->userEmail);
    }

} 