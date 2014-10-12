<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 2:10 PM
 */

namespace Karma\Log\CopChangeLog;


class CopChangeLogHandler {
    /**
     * @var CopChangeLog
     */
    private $copChangeLog;

    function __construct(CopChangeLog $copChangeLog)
    {
        $this->copChangeLog = $copChangeLog;
    }

    public function addChangeLog($userId,$key,$value)
    {
        $this->copChangeLog->create(array(
            'logUserId' => $userId,
            'logKey' => $key,
            'logValue' => $value
        ));
    }

} 