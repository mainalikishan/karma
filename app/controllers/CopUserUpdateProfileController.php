<?php

use Karma\Profile\CopProfileHandler;
use Karma\Validation\CopProfileValidate;

class CopUserUpdateProfileController extends ApiController
{

    /**
     * @var Karma\Profile\CopProfileHandler
     */
    private $copProfileHandler;
    /**
     * @var Karma\Validation\CopProfileValidate
     */
    private $copProfileValidate;

    function __construct(CopProfileHandler $copProfileHandler)
    {
        $this->copProfileHandler = $copProfileHandler;
    }

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

}
