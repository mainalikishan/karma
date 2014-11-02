<?php

use Karma\notification\IndNotificationHandler;

class IndNotificationController extends ApiController

{


    /**
     * @var Karma\notification\IndNotificationHandler
     */
    private $indNotificationHandler;

    public function __construct(IndNotificationHandler $indNotificationHandler)
    {

        $this->indNotificationHandler = $indNotificationHandler;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function updateStatus()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return=$this->copNotificationHandler->updateStatus($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}
