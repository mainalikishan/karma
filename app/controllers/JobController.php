<?php

use Karma\Cache\JobCacheHandler;
use Karma\Jobs\JobApplicationHandler;
use Karma\Jobs\JobApplicationStatusHandler;
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
     * @var Karma\Jobs\JobApplicationHandler
     */
    private $jobApplicationHandler;
    /**
     * @var Karma\Jobs\JobApplicationStatusHandler
     */
    private $jobApplicationStatusHandler;


    /**
     * @param JobsHandler $handler
     * @param JobCacheHandler $jobCacheHandler
     * @param JobApplicationHandler $jobApplicationHandler
     * @param JobApplicationStatusHandler $jobApplicationStatusHandler
     */
    public function __construct(
        JobsHandler $handler,
        JobCacheHandler $jobCacheHandler,
        JobApplicationHandler $jobApplicationHandler,
        JobApplicationStatusHandler $jobApplicationStatusHandler)
    {
        $this->handler = $handler;
        $this->jobCacheHandler = $jobCacheHandler;
        $this->jobApplicationHandler = $jobApplicationHandler;
        $this->jobApplicationStatusHandler = $jobApplicationStatusHandler;
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

    /**
     * @return mixed
     */
    public function apply()
    {

        $post = $this->postRequestHandler();

        if (is_object($post)) {
            try {

                $return = $this->jobApplicationHandler->apply($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
    public function applicationStatus()
    {

        $post = $this->postRequestHandler();

        if (is_object($post)) {
            try {

                $return = $this->jobApplicationStatusHandler->addJobStatus($post);
                return $this->respondSuccess($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}
