<?php

namespace app\api;


abstract class Api
{
    public $apiName=''; //users
    protected $method = ''; //GET|POST|PUT|DELETE
    public $requestUri = [];
    public $requestParams = [];
    protected $action = ''; //Название метод для выполнения


    /**
     * Api constructor.
     */
    public function __construct() {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        //Массив GET параметров разделенных слешем

        $this->requestUri[0] = explode('?', trim($_SERVER['REQUEST_URI'],'/'));
        $this->requestUri[1] = explode('&', $this->requestUri[0][1]);
        $this->apiName=explode('/',$this->requestUri[0][0])[1];
        $this->requestParams = $_REQUEST;

        //Определение метода запроса
        $this->method = $_SERVER['REQUEST_METHOD'];
       
    }

    /**
     * @return mixed
     */
    public function run() {

        //Определение действия для обработки
        $this->action = $this->getAction();

        //Если метод(действие) определен в дочернем классе API
        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    /**
     * @param $data
     * @param int $status
     * @return string
     */
    protected function response($data, $status = 500) {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data);
    }

    /**
     * @param $code
     * @return mixed
     */
    private function requestStatus($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code])?$status[$code]:$status[500];
    }

    /**
     * @return null|string
     */
    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if($this->requestParams['action']=='show'){
                    return 'viewAction';
                } elseif ($this->requestParams['action']=='setstatus'){
                    return 'updateAction';
                } elseif ($this->requestParams['action']=='add' && !empty($this->requestUri[1][0])){
                    return 'createAction';
                }
                break;

            default:
                return null;
        }
    }

    abstract protected function viewAction();
    abstract protected function createAction();
    abstract protected function updateAction();
}