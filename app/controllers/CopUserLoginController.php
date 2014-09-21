<?php
use Karma\Validation\CopLoginValidate;
class CopUserLoginController extends ApiController {

    /**
     * @var Karma\Validation\CopLoginValidate
     */
    private $copLoginValidate;

    function __construct(CopLoginValidate $copLoginValidate )
    {
        $this->copLoginValidate = $copLoginValidate;

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
            if (Auth::attempt(array('userEmail' => $post->userEmail, 'userPassword' => $post->userPassword,'userStatus' => 'Y')))
            {
                echo"success";
            }
            else
            {
                echo "Login Fail.";
            }
        }
        catch(Exception $e){
            return $this->respondUnprocessableEntity($e->getMessage());
        }
    }
}
