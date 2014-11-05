<?php

use Karma\Log\ReportLog\IndReportLogHandler;

class indProfileController extends ApiController {

    /**
     * @var Karma\Log\ReportLog\IndReportLogHandler
     */
    private $indReportLogHandler;

    function __construct(IndReportLogHandler $indReportLogHandler)
    {
        $this->indReportLogHandler = $indReportLogHandler;
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

}
