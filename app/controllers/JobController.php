<?php

use Karma\Jobs\JobsHandler;
use Karma\Jobs\JobsValidate;

class JobController extends  ApiController {
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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
