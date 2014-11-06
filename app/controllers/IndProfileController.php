<?php

use Karma\Log\ReportLog\IndReportLogHandler;
use Karma\Log\UserBlockLog\IndBlockUserLogHandler;

class IndProfileController extends ApiController {

    /**
     * @var Karma\Log\ReportLog\IndReportLogHandler
     */
    private $indReportLogHandler;
    /**
     * @var Karma\Log\UserBlockLog\IndBlockUserLogHandler
     */
    private $indBlockUserLogHandler;

    function __construct(IndReportLogHandler $indReportLogHandler, IndBlockUserLogHandler $indBlockUserLogHandler)
    {
        $this->indReportLogHandler = $indReportLogHandler;
        $this->indBlockUserLogHandler = $indBlockUserLogHandler;
    }

    public function report()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indReportLogHandler->addReportLog($post);
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

                $return = $this->indBlockUserLogHandler->addBlockLog($post);
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

                $return = $this->indBlockUserLogHandler->updateBlockLog($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}
