<?php

use Karma\Jobs\JobsHandler;
use Karma\Jobs\JobsValidate;

class JobController extends ApiController
{
    /**
     * @var Karma\Jobs\JobsValidate
     */
    private $jobsValidate;
    /**
     * @var Karma\Jobs\JobsHandler
     */
    private $handler;

    public function __construct(JobsValidate $jobsValidate, JobsHandler $handler)
    {
        $this->jobsValidate = $jobsValidate;
        $this->handler = $handler;
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
                $this->jobsValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }
            try {
                $return = $this->handler->addJob($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit()
    {

        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->handler->detailsById($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update()
    {
        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $this->jobsValidate->validate($post);
            } catch (Laracasts\Validation\FormValidationException $e) {
                return $this->respondUnprocessableEntity($e->getErrors());
            }
            try {
                $return = $this->handler->updateJob($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy()
    {

        $post = $this->postRequestHandler();
        if (is_object($post)) {
            try {
                $return = $this->handler->destroy($post);
                return $this->respond($return);
            } catch (Exception $e) {
                return $this->respondUnprocessableEntity($e->getMessage());
            }
        }
        return $this->respondUnprocessableEntity();
    }
}
