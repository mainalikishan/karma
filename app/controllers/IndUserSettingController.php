<?php
use Karma\Setting\IndAppSettingHandler;
use Karma\Setting\IndPreferenceHandler;
use Karma\Setting\IndPrivacyHandler;
use Karma\Setting\IndAccountSettingHandler;

/**
 * User: kishan
 * Date: 10/29/14
 * Time: 9:34 PM
 */
class IndUserSettingController extends ApiController
{


    /**
     * @var Karma\Setting\IndPreferenceHandler
     */
    private $indPreferenceHandler;
    /**
     * @var Karma\Setting\IndAppSettingHandler
     */
    private $indAppSettingHandler;
    /**
     * @var Karma\Setting\IndPrivacyHandler
     */
    private $indPrivacyHandler;
    /**
     * @var Karma\Setting\IndAccountSettingHandler
     */
    private $indAccountSettingHandler;


    /**
     * @param IndPreferenceHandler $indPreferenceHandler
     * @param IndAppSettingHandler $indAppSettingHandler
     * @param IndPrivacyHandler $indPrivacyHandler
     * @param IndAccountSettingHandler $indAccountSettingHandler
     */
    public function __construct(
        IndPreferenceHandler $indPreferenceHandler,
        IndAppSettingHandler $indAppSettingHandler,
        IndPrivacyHandler $indPrivacyHandler,
        IndAccountSettingHandler $indAccountSettingHandler
    )
    {
        $this->indPreferenceHandler = $indPreferenceHandler;
        $this->indAppSettingHandler = $indAppSettingHandler;
        $this->indPrivacyHandler = $indPrivacyHandler;
        $this->indAccountSettingHandler = $indAccountSettingHandler;
    }


    /**
     * @return mixed
     */
    public function updatePreference()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indPreferenceHandler->update($post);
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
                $return = $this->indAppSettingHandler->update($post);
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
                $return = $this->indAccountSettingHandler->updateAccountStatus($post);
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
    public function updatePrivacy()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indPrivacyHandler->update($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }


}