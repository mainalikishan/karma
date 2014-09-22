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

    public function loginValidate()
    {
        $post = new stdClass();
        $post->userEmail='thebhandariprakash@gmail.com';
        $post->userPassword='prakash';

        try{
            $this->copLoginValidate->validate($post);
        }
        catch(Laracasts\Validation\FormValidationException $e){
            return $this->respondUnprocessableEntity($e->getErrors());
        }

        try{
            $this->copLogInHandler->login($post);
        }
        catch(Exception $e){
            return $this->respondUnprocessableEntity($e->getMessage());
        }
    }
}
