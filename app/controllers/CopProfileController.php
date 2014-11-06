<?php

use Karma\Cache\CopUserCacheHandler;
use Karma\Log\ReportLog\CopReportLog;
use Karma\Log\ReportLog\CopReportLogHandler;
use Karma\Log\UserBlockLog\CopBlockUserLogHandler;
use Karma\Profile\CopProfileHandler;
use Karma\Profile\CopUserForgotPasswordRequestHandler;
use Karma\Profile\CopUserForgotPasswordVerifyHandler;

class CopProfileController extends ApiController
{

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
    /**
     * @var Karma\Profile\CopProfileHandler
     */
    private $copProfileHandler;
    /**
     * @var Karma\Profile\CopUserForgotPasswordRequestHandler
     */
    private $copUserForgotPasswordRequestHandler;
    /**
     * @var Karma\Profile\CopUserForgotPasswordVerifyHandler
     */
    private $copUserForgotPasswordVerifyHandler;

    /**
     * @param CopProfileHandler $copProfileHandler
     * @param CopUserForgotPasswordRequestHandler $copUserForgotPasswordRequestHandler
     * @param CopUserForgotPasswordVerifyHandler $copUserForgotPasswordVerifyHandler
     * @param CopUserCacheHandler $copUserCacheHandler
     * @param CopReportLogHandler $copReportLogHandler
     * @param CopBlockUserLogHandler $copBlockUserLogHandler
     */
    function __construct(CopProfileHandler $copProfileHandler,
                         CopUserForgotPasswordRequestHandler $copUserForgotPasswordRequestHandler,
                         CopUserForgotPasswordVerifyHandler $copUserForgotPasswordVerifyHandler,
                         CopUserCacheHandler $copUserCacheHandler,
                         CopReportLogHandler $copReportLogHandler,
                         CopBlockUserLogHandler $copBlockUserLogHandler)
    {
        $this->copUserCacheHandler = $copUserCacheHandler;
        $this->copReportLogHandler = $copReportLogHandler;
        $this->copBlockUserLogHandler = $copBlockUserLogHandler;
        $this->copProfileHandler = $copProfileHandler;
        $this->copUserForgotPasswordRequestHandler = $copUserForgotPasswordRequestHandler;
        $this->copUserForgotPasswordVerifyHandler = $copUserForgotPasswordVerifyHandler;
    }

    /**
     * @return mixed
     */
    public function updateProfile()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {

            try {
                $return = $this->copProfileHandler->updateProfile($post);
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

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
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

    // password section

    /**
     * @return mixed
     */
    public function codeRequest()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copUserForgotPasswordRequestHandler->codeRequest($post);
                if (is_array($return)) {
                    \Event::fire('copUser.requestCode', $return['user']);
                    return $this->respondSuccess($return['success']);
                }
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
    public function codeVerify()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copUserForgotPasswordVerifyHandler->verifyCode($post);
                if (is_array($return)) {
                    \Event::fire('copUser.verifyCode', $return['user']);
                    return $this->respondSuccess($return['success']);
                }

                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

}
