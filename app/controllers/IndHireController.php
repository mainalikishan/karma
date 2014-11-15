<?php
use Karma\Hire\IndHireHandler;

/**
 * User: kishan
 * Date: 11/9/14
 * Time: 11:32 AM
 */
class IndHireController extends ApiController
{

    /**
     * @var Karma\Hire\IndHireHandler
     */
    private $indHireHandler;

    public function __construct(IndHireHandler $indHireHandler)
    {
        $this->indHireHandler = $indHireHandler;
    }

    public function requestHire()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indHireHandler->request($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    public function responseHire()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indHireHandler->response($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}