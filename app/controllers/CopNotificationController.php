<?php

use Karma\Notification\CopNotificationHandler;

/**
 * Class CopNotificationController
 */
class CopNotificationController extends ApiController

{


    /**
     * @var Karma\notification\CopNotificationHandler
     */
    private $copNotificationHandler;

    /**
     * @param CopNotificationHandler $copNotificationHandler
     */
    public function __construct(CopNotificationHandler $copNotificationHandler)
    {

        $this->copNotificationHandler = $copNotificationHandler;
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
                $return = $this->copNotificationHandler->updateStatus($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}
