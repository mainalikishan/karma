<?php

use Karma\Jobs\JobApplicationHandler;

class JobApplicationController extends ApiController
{
    /**
     * @var Karma\Jobs\JobApplicationHandler
     */
    private $applicationHandler;

    /**
     * @param JobApplicationHandler $applicationHandler
     */
    public function __construct(JobApplicationHandler $applicationHandler)
    {
        $this->applicationHandler = $applicationHandler;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function apply()
    {

        $post = $this->postRequestHandler();

        if (is_object($post)) {
            try {

                $return = $this->applicationHandler->apply($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}
