<?php

class ApiController extends BaseController
{
    protected $statusCode = 200;

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }


    /**
     * @param string $message
     * @return mixed
     */
    public function respondUnprocessableEntity($message = 'Unprocessable Entity')
    {
        return $this->setStatusCode(422)->respondWithError($message);
    }


    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    public function respondSuccess($message = '')
    {
        return $this->setStatusCode(200)->respondWithSuccess($message);
    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }


    /**
     * @param $message
     * @return mixed
     */
    public function respondWithSuccess($message)
    {
        return $this->makeResponse($message);
    }


    /**
     * @param $message
     * @return mixed
     */
    public function respondWithError($message)
    {
        return $this->makeResponse($message);
    }


    /**
     * @param $message
     * @return mixed
     */
    private function makeResponse($message)
    {
        return $this->respond([
            'response' => $message,
            'statusCode' => $this->getStatusCode()
        ]);
    }


    /**
     * @return mixed
     */
    public function postRequestHandler()
    {
//        $receive = file_get_contents("php://input");
//        return (json_decode($receive, true));
        return (object)$_POST;
    }


} 