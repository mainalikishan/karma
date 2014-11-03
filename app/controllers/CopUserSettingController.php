<?php
use Karma\Setting\CopAppSettingHandler;

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

    public function __construct(CopAppSettingHandler $copAppSettingHandler)
    {
        $this->copAppSettingHandler = $copAppSettingHandler;
    }

    public function updateAppSetting()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copAppSettingHandler->update($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }


} 