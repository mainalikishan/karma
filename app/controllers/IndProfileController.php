<?php

use Karma\Log\ReportLog\IndReportLogHandler;
use Karma\Log\UserBlockLog\IndBlockUserLogHandler;
use Karma\Profile\IndProfileBasicHandler;
use Karma\Profile\IndProfileEducationHandler;
use Karma\Profile\IndProfileExperienceHandler;
use Karma\Profile\IndProfileWhatIDoHandler;

class IndProfileController extends ApiController
{
    /**
     * @var Karma\Profile\IndProfileBasicHandler
     */
    private $indProfileBasicHandler;
    /**
     * @var Karma\Profile\IndProfileWhatIDoHandler
     */
    private $indProfileWhatIDoHandler;
    /**
     * @var Karma\Profile\IndProfileExperienceHandler
     */
    private $indProfileExperienceHandler;
    /**
     * @var Karma\Profile\IndProfileEducationHandler
     */
    private $indProfileEducationHandler;
    /**
     * @var Karma\Log\ReportLog\IndReportLogHandler
     */
    private $indReportLogHandler;
    /**
     * @var Karma\Log\UserBlockLog\IndBlockUserLogHandler
     */
    private $indBlockUserLogHandler;


    /**
     * @param IndProfileBasicHandler $indProfileBasicHandler
     * @param IndProfileWhatIDoHandler $indProfileWhatIDoHandler
     * @param IndProfileExperienceHandler $indProfileExperienceHandler
     * @param IndProfileEducationHandler $indProfileEducationHandler
     * @param IndReportLogHandler $indReportLogHandler
     * @param IndBlockUserLogHandler $indBlockUserLogHandler
     */
    public function __construct(
        IndProfileBasicHandler $indProfileBasicHandler,
        IndProfileWhatIDoHandler $indProfileWhatIDoHandler,
        IndProfileExperienceHandler $indProfileExperienceHandler,
        IndProfileEducationHandler $indProfileEducationHandler,
        IndReportLogHandler $indReportLogHandler,
        IndBlockUserLogHandler $indBlockUserLogHandler)
    {
        $this->indProfileBasicHandler = $indProfileBasicHandler;
        $this->indProfileWhatIDoHandler = $indProfileWhatIDoHandler;
        $this->indProfileExperienceHandler = $indProfileExperienceHandler;
        $this->indProfileEducationHandler = $indProfileEducationHandler;
        $this->indReportLogHandler = $indReportLogHandler;
        $this->indBlockUserLogHandler = $indBlockUserLogHandler;
    }


    /**
     * @return mixed
     */
    public function updateBasic()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indProfileBasicHandler->update($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }


    /**
     * @return mixed
     */
    public function updateWhatIDo()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indProfileWhatIDoHandler->update($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }


    /**
     * @return mixed
     */
    public function updateExperience()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indProfileExperienceHandler->update($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }


    /**
     * @return mixed
     */
    public function updateEducation()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indProfileEducationHandler->update($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    /**
     * @return mixed
     */
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


    /**
     * @return mixed
     */
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


    /**
     * @return mixed
     */
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
