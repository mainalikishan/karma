<?php

use Karma\Profile\CopAccountActivationHandler;
use Karma\Validation\copAccountActivationValidate;

class CopUserActivationController extends ApiController
{
    /**
     * @var Karma\Profile\CopAccountActivationHandler
     */
    private $copAccountActivationHandler;


    /**
     * @var
     */
    private $copAccountActivationValidate;

    function __construct(CopAccountActivationValidate $copAccountActivationValidate, CopAccountActivationHandler $copAccountActivationHandler)
    {

        $this->copAccountActivationHandler = $copAccountActivationHandler;
        $this->copAccountActivationValidate = $copAccountActivationValidate;
    }


    public function accountActivation()
    {
        $post = $this->postRequestHandler();

        if (is_object($post)) {
            try {
                $this->copAccountActivationValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try {
                $return = $this->copAccountActivationHandler->accountActivation($post);
                return $this->respondSuccess($return);

            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }

}
