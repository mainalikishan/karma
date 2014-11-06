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

    /**
     * @param IndChangeLog $indChangeLog
     */
    function __construct(IndChangeLog $indChangeLog)
    {
        $this->indChangeLog = $indChangeLog;
    }

    /**
     * @param $userId
     * @param $key
     * @param $value
     */
    public function addChangeLog($userId, $key, $value)
    {
        $this->copChangeLog->create(array(
            'logUserId' => $userId,
            'logKey' => $key,
            'logValue' => $value
        ));
    }

} 