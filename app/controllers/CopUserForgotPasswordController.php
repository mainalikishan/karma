<?php

//handlers
use Karma\Profile\CopUserForgotPasswordRequestHandler;
use Karma\Profile\CopUserForgotPasswordVerifyHandler;

//validation
use Karma\Validation\CopUserForgotPasswordCodeVerifyValidate;
use Karma\Validation\CopUserForgotPasswordRequestValidate;

class CopUserForgotPasswordController extends ApiController
{

    /**
     * @var Karma\Validation\CopUserForgotPasswordRequestValidate
     */
    private $copUserForgotPasswordRequestValidate;
    /**
     * @var Karma\Profile\CopUserForgotPasswordRequestHandler
     */
    private $copUserForgotPasswordRequestHandler;


    private $copUserForgotPasswordVerifyHandler;
    /**
     * @var Karma\Validation\CopUserForgotPasswordCodeVerifyValidate
     */
    private $copUserForgotPasswordCodeVerifyValidate;

    function __construct(CopUserForgotPasswordRequestValidate $copUserForgotPasswordRequestValidate,
                         CopUserForgotPasswordRequestHandler $copUserForgotPasswordRequestHandler,
                         CopUserForgotPasswordVerifyHandler $copUserForgotPasswordVerifyHandler,
                         CopUserForgotPasswordCodeVerifyValidate $copUserForgotPasswordCodeVerifyValidate
    )
    {
        $this->copUserForgotPasswordRequestValidate = $copUserForgotPasswordRequestValidate;
        $this->copUserForgotPasswordRequestHandler = $copUserForgotPasswordRequestHandler;

        $this->copUserForgotPasswordVerifyHandler = $copUserForgotPasswordVerifyHandler;
        $this->copUserForgotPasswordCodeVerifyValidate = $copUserForgotPasswordCodeVerifyValidate;
    }

    public function codeRequest()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $this->copUserForgotPasswordRequestValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try {
                $return = $this->copUserForgotPasswordRequestHandler->codeRequest($post);
                \Event::fire('copUser.requestCode', $return);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }


    public function codeVerify()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $this->copUserForgotPasswordCodeVerifyValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try {
                $return = $this->copUserForgotPasswordVerifyHandler->verifyCode($post);
                \Event::fire('copUser.verifyCode', $return);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }
}
