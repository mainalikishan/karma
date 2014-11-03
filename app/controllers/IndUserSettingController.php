<?php
use Karma\Setting\IndAppSettingHandler;
use Karma\Setting\IndPreferenceHandler;
use Karma\Setting\IndPrivacyHandler;

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

    public function __construct(
        IndPreferenceHandler $indPreferenceHandler,
        IndAppSettingHandler $indAppSettingHandler,
        IndPrivacyHandler $indPrivacyHandler
    )
    {
        $this->indPreferenceHandler = $indPreferenceHandler;
        $this->indAppSettingHandler = $indAppSettingHandler;
        $this->indPrivacyHandler = $indPrivacyHandler;
    }

    public function updatePreference()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indPreferenceHandler->update($post);
                return $this->respond($return);
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
                $return = $this->indAppSettingHandler->update($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

    public function updatePrivacy()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indPrivacyHandler->update($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }


}