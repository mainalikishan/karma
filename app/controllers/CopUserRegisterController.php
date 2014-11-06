<?php

use Karma\Profile\CopAccountActivationHandler;
use Karma\Registration\CopUserRegister;

/**
 * Class CopUserRegisterController
 */
class CopUserRegisterController extends ApiController
{

    /**
     * @var Karma\Registration\CopUserRegister
     */
    private $copUserRegister;
    /**
     * @var Karma\Profile\CopAccountActivationHandler
     */
    private $copAccountActivationHandler;


    /**
     * @param CopUserRegister $copUserRegister
     * @param CopAccountActivationHandler $copAccountActivationHandler
     */
    public function __construct(CopUserRegister $copUserRegister,
                         CopAccountActivationHandler $copAccountActivationHandler)
    {
        $this->copUserRegister = $copUserRegister;
        $this->copAccountActivationHandler = $copAccountActivationHandler;
    }

    /**
     * @return mixed
     */
    public function register()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $user = $this->copUserRegister->checkRegistration($post);
                return $this->respondSuccess($user);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    /**
     * @return mixed
     */
    public function accountActivation()
    {
        $post = $this->postRequestHandler();

        if (is_object($post)) {
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