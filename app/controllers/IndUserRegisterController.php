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
        $post['oauth_type'] = "indLinkedinRegister";
        try{
            return $this->indUserRegister->checkRegistration($post);
        }
        catch(Exception $e){
            return $this->respondUnprocessableEntity($e->getMessage());
        }

    }
}
