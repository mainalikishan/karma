<?php

use Karma\Profile\CopUserForgotPasswordRequestHandler;
use Karma\Validation\CopUserForgotPasswordRequestValidate;

class CopUserForgotPasswordController extends ApiController {


    /**
     * @var Karma\Validation\CopUserForgotPasswordRequestValidate
     */
    private $copUserForgotPasswordRequestValidate;
    /**
     * @var Karma\Profile\CopUserForgotPasswordRequestHandler
     */
    private $copUserForgotPasswordRequestHandler;

    function __construct(CopUserForgotPasswordRequestValidate $copUserForgotPasswordRequestValidate, CopUserForgotPasswordRequestHandler $copUserForgotPasswordRequestHandler)
    {
        $this->copUserForgotPasswordRequestValidate = $copUserForgotPasswordRequestValidate;
        $this->copUserForgotPasswordRequestHandler = $copUserForgotPasswordRequestHandler;
    }

    public function codeRequest()
    {
        $post = $this->postRequestHandler();
        if(is_object($post))
        {
            try{
                $this->copUserForgotPasswordRequestValidate->validate($post);
            }
            catch(Laracasts\Validation\FormValidationException $e){
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try{
                $return = $this->copUserForgotPasswordRequestHandler->codeRequest($post);
                \Event::fire('copUser.requestCode', $return);
                return $this->respond($return);
            }
            catch(Exception $e){
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }
}
