<?php

use Karma\Cache\CopUserCacheHandler;
use Karma\Log\ReportLog\CopReportLog;
use Karma\Log\ReportLog\CopReportLogHandler;
use Karma\Log\UserBlockLog\CopBlockUserLogHandler;

class CopProfileController extends ApiController {

    /**
     * @var Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;
    /**
     * @var Karma\Log\ReportLog\CopReportLogHandler
     */
    private $copReportLogHandler;
    /**
     * @var Karma\Log\UserBlockLog\CopBlockUserLogHandler
     */
    private $copBlockUserLogHandler;

    function __construct(CopUserCacheHandler $copUserCacheHandler,
                         CopReportLogHandler $copReportLogHandler,
                         CopBlockUserLogHandler $copBlockUserLogHandler)
    {
        $this->copUserCacheHandler = $copUserCacheHandler;
        $this->copReportLogHandler = $copReportLogHandler;
        $this->copBlockUserLogHandler = $copBlockUserLogHandler;
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

    public function blockUser()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {

                $return = $this->copBlockUserLogHandler->addBlockLog($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    public function unBlockUser()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {

                $return = $this->copBlockUserLogHandler->updateBlockLog($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

}
