<?php
use Karma\Login\CopLogInHandler;
use Karma\Validation\CopLoginValidate;
class CopUserLoginController extends ApiController {

    /**
     * @var Karma\Validation\CopLoginValidate
     */
    private $copLoginValidate;
    /**
     * @var Karma\Login\CopLogInHandler
     */
    private $copLogInHandler;

    function __construct(CopLoginValidate $copLoginValidate, CopLogInHandler $copLogInHandler )
    {
        $this->copLoginValidate = $copLoginValidate;

        $this->copLogInHandler = $copLogInHandler;
    }

    public function login()
    {
        $post = $this->postRequestHandler();
        if(is_object($post))
        {
            try{
              $this->copLoginValidate->validate($post);
            }
            catch(Laracasts\Validation\FormValidationException $e){
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            try{
               $return = $this->copLogInHandler->login($post);
               return $this->respond($return);
            }
            catch(Exception $e){
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }

        return $this->respondUnprocessableEntity();
    }
}
