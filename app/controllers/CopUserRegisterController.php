<?php

use Karma\Registration\CopUserRegister;

class CopUserRegisterController extends ApiController {


    /**
     * @var Karma\Registration\CopUserRegister
     */
    private $copUserRegister;

    function __construct(CopUserRegister $copUserRegister)
    {
        $this->copUserRegister = $copUserRegister;
    }

    public function register()
	{
        //$post = $this->postRequestHandler();
        $post['oauth_type']='copCustomRegister';
        try{
            return $this->copUserRegister->checkRegistration($post);
        }
        catch(Exception $e){
            return $this->respondUnprocessableEntity($e->getMessage());
        }
	}
}