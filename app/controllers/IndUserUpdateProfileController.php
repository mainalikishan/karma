<?php
use Karma\Profile\IndProfileHandler;
use Karma\Validation\IndProfileValidate;

/**
 * User: kishan
 * Date: 9/28/14
 * Time: 11:39 AM
 */
class IndUserUpdateProfileController extends ApiController
{

    /**
     * @var Karma\Validation\IndProfileValidate
     */
    private $indProfileValidate;
    /**
     * @var Karma\Profile\IndProfileHandler
     */
    private $indProfileHandler;

    public function __construct(IndProfileValidate $indProfileValidate, IndProfileHandler $indProfileHandler)
    {

        $this->indProfileValidate = $indProfileValidate;
        $this->indProfileHandler = $indProfileHandler;
    }

    public function updateProfile()
    {
        $post = $this->postRequestHandler();

        if (is_object($post)) {
            // validate inputs
            try {
                $this->indProfileValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }

            // lets update as per updateType requested
            try {
                switch ($post->updateType) {
                    case "basic":
                        $return = $this->indProfileHandler->basic($post);
                        break;
                    case "experience":
                        $return = $this->indProfileHandler->experience($post);
                        break;
                    case "education":
                        $return = $this->indProfileHandler->education($post);
                        break;
                    case "whatIDo":
                        $return = $this->indProfileHandler->education($post);
                        break;
                    default:
                        return $this->respondUnprocessableEntity();
                }
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}