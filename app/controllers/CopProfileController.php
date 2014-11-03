<?php

use Karma\Cache\CopUserCacheHandler;

class CopProfileController extends ApiController {


    /**
     * @var Karma\Cache\CopUserCacheHandler
     */
    private $copUserCacheHandler;

    function __construct(CopUserCacheHandler $copUserCacheHandler)
    {
        $this->copUserCacheHandler = $copUserCacheHandler;
    }

    public function view()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->copUserCacheHandler->viewProfile($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

}
