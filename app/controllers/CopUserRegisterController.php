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

    function __construct(CopUserRegister $copUserRegister, CopRegisterValidate $copRegisterValidate)
    {
        $this->copUserRegister = $copUserRegister;
        $this->copRegisterValidate = $copRegisterValidate;
    }

    public function register()
	{
	    //$post = $this->postRequestHandler();
        //$post = new stdClass();
       // $post->userOuthType='copCustomRegister';
        //$post->userOauthId='9841173139';
        //$post->userCompanyName='Jagirr Inc.';
       // $post->userEmail='thebhandariprakash@gmail.com';
       // $post->userPassword='prakash';

        $post = $this->postRequestHandler();
        if(is_object($post))
        {
            try{
                $this->copRegisterValidate->validate($post);
            }
            catch(Laracasts\Validation\FormValidationException $e){
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try{
                return $this->copUserRegister->checkRegistration($post);
            }
            catch(Exception $e){
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}