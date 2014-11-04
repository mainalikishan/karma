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
     * @var Karma\Profile\IndProfileHandler
     */
    private $indProfileHandler;

    public function __construct(IndProfileHandler $indProfileHandler)
    {
        $this->indProfileHandler = $indProfileHandler;
    }

    public function updateProfile()
    {
        $post = $this->postRequestHandler();

        if (is_object($post)) {

            // lets update as per updateType requested
            try {
                switch ($post->updateType) {
                    case "basic":
                        $return = $this->indProfileHandler->basic($post);
                        break;
                    case "whatIDo":
                        $return = $this->indProfileHandler->whatIDo($post);
                        break;
                    case "experience":
                        $return = $this->indProfileHandler->experience($post);
                        break;
                    case "education":
                        $return = $this->indProfileHandler->education($post);
                        break;
                    default:
                        return $this->respondUnprocessableEntity();
                }
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}