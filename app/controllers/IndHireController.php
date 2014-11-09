<?php
use Karma\Hire\IndHirehandler;

/**
 * User: kishan
 * Date: 11/9/14
 * Time: 11:32 AM
 */
class IndHireController extends ApiController
{

    /**
     * @var Karma\Hire\IndHirehandler
     */
    private $indHirehandler;

    public function __construct(IndHirehandler $indHirehandler)
    {
        $this->indHirehandler = $indHirehandler;
    }

    public function requestHire()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->indHirehandler->request($post);
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
                $return = $this->indHirehandler->response($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}