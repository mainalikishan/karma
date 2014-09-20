<?php

use Karma\Registration\IndUserRegister;

class IndUserController extends ApiController
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
        return $this->indUserRegister->checkRegistration($post);
    }
}
