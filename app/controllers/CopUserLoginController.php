<?php
use Karma\Login\CopLogInHandler;
use Karma\Validation\CopLoginValidate;
class CopUserLoginController extends ApiController {

    /**
     * @var Karma\Login\CopLogInHandler
     */
    private $copLogInHandler;

    function __construct(CopLogInHandler $copLogInHandler )
    {
        $this->copLogInHandler = $copLogInHandler;
    }

    public function login()
    {
        $post = $this->postRequestHandler();
        if(is_object($post))
        {
            try{
               $return = $this->copLogInHandler->login($post);
               return $this->respondSuccess($return);
            }
            catch(Exception $e){
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }
}
