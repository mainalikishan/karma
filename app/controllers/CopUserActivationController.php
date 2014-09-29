<?php

class CopUserActivationController extends ApiController {

    /**
     * @var CopAccountValidationValidate
     */
    private $accountValidationValidate;

    function __construct(CopAccountValidationValidate $accountValidationValidate)
    {
        $this->accountValidationValidate = $accountValidationValidate;
    }

    public function changePassword()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $this->accountValidationValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try {
                $return = $this->copChangePasswordHandler->changePassword($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

}
