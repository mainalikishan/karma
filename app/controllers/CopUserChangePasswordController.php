<?php

use Karma\Profile\CopChangePasswordHandler;
use Karma\Validation\CopChangePasswordValidate;

class CopUserChangePasswordController extends ApiController
{

    /**
     * @var Karma\Validation\CopChangePasswordValidate
     */
    private $changePasswordValidate;
    /**
     * @var Karma\Profile\CopChangePasswordHandler
     */
    private $copChangePasswordHandler;

    public function __construct(CopChangePasswordValidate $changePasswordValidate, CopChangePasswordHandler $copChangePasswordHandler)
    {
        $this->changePasswordValidate = $changePasswordValidate;
        $this->copChangePasswordHandler = $copChangePasswordHandler;
    }

    public function changePassword()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $this->changePasswordValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }

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
