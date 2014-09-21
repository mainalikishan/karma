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
        $post = new stdClass();
        $post->userOuthType='copCustomRegister';
        $post->userOauthId='9841173139';
        $post->userCompanyName='Jagirr Inc.';
        $post->userEmail='thebhandariprakash5@gmail.com';
        $post->userPassword='prakash';
        try{
            $this->copRegisterValidate->validate($post);
        }
        catch(Laracasts\Validation\FormValidationException $e){
            return $this->respondUnprocessableEntity($e->getErrors());
        }

        try{
            $this->copRegisterValidate->validate($post);
            return $this->copUserRegister->checkRegistration($post);
        }
        catch(Exception $e){
            return $this->respondUnprocessableEntity($e->getMessage());
        }
	}
}