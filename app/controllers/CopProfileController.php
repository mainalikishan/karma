<?php

use Karma\Cache\CopUserCacheHandler;
use Karma\Log\ReportLog\CopReportLog;
use Karma\Log\ReportLog\CopReportLogHandler;

class CopProfileController extends ApiController {

    /**
     * @var Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;
    /**
     * @var Karma\Log\ReportLog\CopReportLogHandler
     */
    private $copReportLogHandler;

    function __construct(CopUserCacheHandler $copUserCacheHandler, CopReportLogHandler $copReportLogHandler)
    {
        $this->copUserCacheHandler = $copUserCacheHandler;
        $this->copReportLogHandler = $copReportLogHandler;
    }

    public function view()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copUserCacheHandler->viewProfile($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    public function report()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copReportLogHandler->addReportLog($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

}
