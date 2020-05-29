<?php
require_once('Model.php');

abstract class Api
{

    protected $model = Model::Class;
    static $apiName = '';

    static function get_apiname()
    {
        return static::$apiName;
    }

    protected $method = ''; //GET|POST|PUT|DELETE
    public $requestUri = [];
    public $requestParams = [];
    public $requestBody = '';

    protected $action = ''; //Название метод для выполнения


    public function __construct()
    {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        //Массив GET параметров разделенных слешем
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        array_shift($this->requestUri); #remove api
        array_shift($this->requestUri); #remove model


        $this->requestParams = $_REQUEST;
        $this->requestBody = file_get_contents('php://input');

        //Определение метода запроса
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

    public function run()
    {
        $this->action = $this->getAction();
         if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    protected function response($data, $status = 500)
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    private function requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if ($this->requestUri) {
                    return 'retrieveAction';
                } else {
                    return 'readAction';
                }
                break;
            case 'POST':
                return 'createAction';
                break;
            case 'PUT':
                return 'updateAction';
                break;
            case 'DELETE':
                return 'destroyAction';
                break;
            default:
                return null;
        }
    }

    /**
     * Метод GET
     * Вывод списка всех записей
     * http://ДОМЕН/models
     * @return string
     */
    public function readAction()
    {
        $data = $this->model::read();
        if ($data) {
            return $this->response($data, 200);
        }
        return $this->response('Data not found', 404);
    }

    /**
     * Метод GET
     * Просмотр отдельной записи (по id)
     * http://ДОМЕН/models/id
     * @return string
     */
    public function retrieveAction()
    {
        $id = array_shift($this->requestUri);
        if ($id) {
            $data = $this->model::retrieve($id);
            if ($data) {
                return $this->response($data, 200);
            }
        }
        return $this->response('Data not found', 404);
    }

    /**
     * Метод DELETE
     * Удаление отдельной записи (по ее id)
     * http://ДОМЕН/models/id
     * @return string
     */
    public function destroyAction()
    {
        $id = array_shift($this->requestUri);
        if (!$id || !$this->model::retrieve($id)) {
            return $this->response("Task with id=$id not found", 404);
        }
        if (Task::destroy($id)) {
            return $this->response('Data deleted.', 200);
        }
        return $this->response("Delete error", 500);
    }

    /**
     * Метод PUT
     * Обновление отдельной записи (по ее id)
     * http://ДОМЕН/models/id + body json
     * @return string
     */
    public function updateAction()
    {
        $id = array_shift($this->requestUri);
        if (!$id || !$this->model::retrieve($id)) {
            return $this->response("Task with id=$id not found", 404);
        }

        if ($this->requestBody) {
            $data = json_decode($this->requestBody, TRUE);
            if ($data) {
                if ($this->model::update($id, $data)) {
                    return $this->response('Data updated.', 200);
                }
            }
        }
        return $this->response("Update error", 400);
    }

    /**
     * Метод POST
     * Создание новой записи
     * http://ДОМЕН/models + body json
     * @return string
     */
    public function createAction()
    {
        if ($this->requestBody) {
            $data = json_decode($this->requestBody, TRUE);
            if ($data) {
                if ($this->model::create($data)) {
                    return $this->response('Data updated.', 200);
                }
            }
        }

        return $this->response("Create error", 500);
    }

}