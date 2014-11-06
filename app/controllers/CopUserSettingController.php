<?php
use Karma\Profile\CopChangePasswordHandler;
use Karma\Setting\CopAccountSettingHandler;
use Karma\Setting\CopAppSettingHandler;
use Karma\Setting\CopPreferenceHandler;

/**
 * User: kishan
 * Date: 11/3/14
 * Time: 9:11 PM
 */
class CopUserSettingController extends ApiController
{


    /**
     * @var Karma\Setting\CopAppSettingHandler
     */
    private $copAppSettingHandler;
    /**
     * @var Karma\Setting\CopPreferenceHandler
     */
    private $copPreferenceHandler;
    /**
     * @var Karma\Setting\CopAccountSettingHandler
     */
    private $copAccountSettingHandler;
    /**
     * @var Karma\Profile\CopChangePasswordHandler
     */
    private $copChangePasswordHandler;

    public function __construct(
        CopAppSettingHandler $copAppSettingHandler,
        CopPreferenceHandler $copPreferenceHandler,
        CopAccountSettingHandler $copAccountSettingHandler,
        CopChangePasswordHandler $copChangePasswordHandler)
    {
        $this->copAppSettingHandler = $copAppSettingHandler;
        $this->copPreferenceHandler = $copPreferenceHandler;
        $this->copAccountSettingHandler = $copAccountSettingHandler;
        $this->copChangePasswordHandler = $copChangePasswordHandler;
    }

    public function updatePreference()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copPreferenceHandler->update($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

    public function updateAppSetting()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copAppSettingHandler->update($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

    public function updateAccountStatus()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copAccountSettingHandler->updateAccountStatus($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

    public function updatePassword()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copChangePasswordHandler->changePassword($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }


} 