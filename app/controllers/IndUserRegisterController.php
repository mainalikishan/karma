<?php

use Karma\Registration\IndUserRegister;

class IndUserRegisterController extends ApiController
{
    /**
     * @var Karma\Registration\IndUserRegister
     */
    private $indUserRegister;

    function __construct(IndUserRegister $indUserRegister)
    {
        $this->indUserRegister = $indUserRegister;
    }

    /**
     * @return mixed
     */
    public function login()
    {
        // $post = $this->postRequestHandler();
        $post = new stdClass();
        $post->oauthType='indFacebookRegister';
        $post->userCompanyName='Jagirr Inc.';
        $post->userEmail='thebhandariprakash@gmail.com';
        $post->userPassword='prakash';
        return $this->indUserRegister->checkRegistration($post);

//        try{
//            return $this->indUserRegister->checkRegistration($post);
//        }
//        catch(Exception $e){
//            return $this->respondUnprocessableEntity($e->getMessage());
//        }

    }
}
