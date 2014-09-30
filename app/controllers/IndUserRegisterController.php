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
        $post = $this->postRequestHandler();

        $return = $this->indUserRegister->checkRegistration($post);
        return $this->respond($return);
//        try{
//            $return = $this->indUserRegister->checkRegistration($post);
//            return $this->respond($return);
//        }
//        catch(Exception $e){
//            return $this->respondUnprocessableEntity($e->getMessage());
//        }

    }
}
