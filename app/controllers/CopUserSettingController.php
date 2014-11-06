<?php
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
     * @param CopAppSettingHandler $copAppSettingHandler
     * @param CopPreferenceHandler $copPreferenceHandler
     * @param CopAccountSettingHandler $copAccountSettingHandler
     */
    public function __construct(
        CopAppSettingHandler $copAppSettingHandler,
        CopPreferenceHandler $copPreferenceHandler,
        CopAccountSettingHandler $copAccountSettingHandler)
    {
        $this->copAppSettingHandler = $copAppSettingHandler;
        $this->copPreferenceHandler = $copPreferenceHandler;
        $this->copAccountSettingHandler = $copAccountSettingHandler;
    }

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
    public function updatePassword()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copAccountSettingHandler->changePassword($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }


} 