<?php
require_once('Model.php');

abstract class Api
{

    protected $model = Model::Class;
    static $apiName = '';
    public $filter = [];

    static function get_apiname()
    {
        return static::$apiName;
    }

    public $method = ''; //GET|POST|PUT|DELETE
    public $requestUri = [];
    public $requestParams = [];
    public $requestBody = '';
    public $headers = '';
    protected $action = ''; //name function for action

    public function __construct()
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: *");
        header("Content-Type: application/json");

        //Array GET request split '/'
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        array_shift($this->requestUri); #remove api
        array_shift($this->requestUri); #remove model

        $this->requestParams = $_REQUEST;
        $this->requestBody = file_get_contents('php://input');
        $this->headers = getallheaders();
        //Check Header
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Unexpected Header");
            }
        }

    }

    public function response($data, $status = 500)
    {
        if (gettype($data) != 'array') {
            $data = ['message' => $data];
        }
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    private function requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            302 => 'Found',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            409 => 'Conflict',
            413 => 'Request Entity Too Large',
            415 => 'Unsupported Media Type',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }


    /**
     * Method GET
     * http://domen/models
     * @return string
     */
    public function readAction()
    {
        $data = $this->model::read($this->filter);
        return $this->response(['data' => $data], 200);
    }


    /**
     * Method DELETE
     * http://domen/models/id
     * @return string
     */
    public function destroyAction()
    {
        if (isset($this->requestUri[0])) {
            $this->filter[$this->model::key_field()] = $this->requestUri[0];
            if ($item = $this->model::destroy($this->filter)) {
                return $this->response($item, 200);
            }
        }
        return $this->response("Delete error", 404);

    }

    /**
     * Method PUT
     * http://domen/models/id + body json
     * @return string
     */
    public function updateAction()
    {
        if (isset($this->requestUri[0])) {
            $this->filter[$this->model::key_field()] = $this->requestUri[0];
            if ($this->requestBody) {
                $data = json_decode($this->requestBody, true);
                if ($data) {
                    if ($item = $this->model::update($this->filter, $this->model::validate($data))) {
                        return $this->response($item, 200);
                    }
                }
            }
        }
        return $this->response("Update error", 404);
    }

    /**
     * Method POST
     * http://domen/models + body json
     * @return string
     */
    public function createAction()
    {
        if ($this->requestBody) {
            $data = json_decode($this->requestBody, true);
            if ($data) {
                if ($this->model::create($this->model::validate($data))) {
                    return $this->response('Data updated.', 200);
                }
            }
        }

        return $this->response("Create error", 500);
    }

}