<?php

use Karma\Registration\IndUserRegister;

class IndUserRegisterController extends ApiController
{
    /**
     * @var Karma\Registration\IndUserRegister
     */
    private $indUserRegister;


    /**
     * @param IndUserRegister $indUserRegister
     */
    public function __construct(IndUserRegister $indUserRegister)
    {
        $this->indUserRegister = $indUserRegister;
    }

    /**
     * @return mixed
     */
    public function login()
    {
        $post = $this->postRequestHandler();
        try{
            $return = $this->indUserRegister->checkRegistration($post);
            return $this->respondSuccess($return);
        }
        catch(Exception $e){
            return $this->respondUnprocessableEntity($e->getMessage());
        }

    }
}
