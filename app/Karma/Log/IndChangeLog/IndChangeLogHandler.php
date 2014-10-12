<?php
/**
 * User: Prakash
 * Date: 9/28/14
 * Time: 2:10 PM
 */

namespace Karma\Log\IndChangeLog;


class IndChangeLogHandler
{
    /**
     * @var IndChangeLog
     */
    private $indChangeLog;

    function __construct(IndChangeLog $indChangeLog)
    {
        $this->indChangeLog = $indChangeLog;
    }

    public function addChangeLog($userId, $key, $value)
    {
        $this->copChangeLog->create(array(
            'logUserId' => $userId,
            'logKey' => $key,
            'logValue' => $value
        ));
    }

} 