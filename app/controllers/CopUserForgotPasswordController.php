<?php

use Karma\Validation\CopUserForgotPasswordRequestValidate;

class CopUserForgotPasswordController extends ApiController {


    /**
     * @var Karma\Validation\CopUserForgotPasswordRequestValidate
     */
    private $copUserForgotPasswordRequestValidate;

    function __construct(CopUserForgotPasswordRequestValidate $copUserForgotPasswordRequestValidate)
    {
        $this->copUserForgotPasswordRequestValidate = $copUserForgotPasswordRequestValidate;
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
                $return = $this->copLogInHandler->login($post);
                return $this->respond($return);
            }
            catch(Exception $e){
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }
}
