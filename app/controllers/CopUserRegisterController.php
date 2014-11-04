<?php

use Karma\Registration\CopUserRegister;
use Karma\Validation\CopRegisterValidate;

class CopUserRegisterController extends ApiController {

    /**
     * @var Karma\Registration\CopUserRegister
     */
    private $copUserRegister;
    /**
     * @var Karma\Validation\CopRegisterValidate
     */
    private $copRegisterValidate;

    function __construct(CopUserRegister $copUserRegister)
    {
        $this->copUserRegister = $copUserRegister;
    }

    public function register()
	{
	   $post = $this->postRequestHandler();
        if(is_object($post))
        {
            try{
                $user =  $this->copUserRegister->checkRegistration($post);
                return $this->respondSuccess($user);
            }
            catch(Exception $e){
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}