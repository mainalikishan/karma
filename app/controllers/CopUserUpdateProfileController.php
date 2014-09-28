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

    function __construct(CopProfileValidate $copProfileValidate, CopProfileHandler $copProfileHandler)
    {
        $this->copProfileHandler = $copProfileHandler;
        $this->copProfileValidate = $copProfileValidate;
    }

    public function updateProfile()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $this->copProfileValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try {
                $return = $this->copProfileHandler->updateProfile($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

}
