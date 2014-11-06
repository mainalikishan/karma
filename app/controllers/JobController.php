<?php

use Karma\Cache\JobCacheHandler;
use Karma\Jobs\JobsHandler;

class JobController extends ApiController

{
    /**
     * @var Karma\Jobs\JobsHandler
     */
    private $handler;
    /**
     * @var Karma\Cache\JobCacheHandler
     */
    private $jobCacheHandler;

    /**
     * @param JobsHandler $handler
     * @param JobCacheHandler $jobCacheHandler
     */
    public function __construct(JobsHandler $handler, JobCacheHandler $jobCacheHandler)
    {
        $this->handler = $handler;
        $this->jobCacheHandler = $jobCacheHandler;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->handler->addJob($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }


    /**
     * @return mixed
     */
    public function selectJobCache()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->jobCacheHandler->select($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {

            try {
                $return = $this->handler->updateJob($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    /**
     * @return mixed
     */
    public function destroy()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->handler->destroy($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}
