<?php

namespace app\api;


use app\db\SafeMySQL;
use RuntimeException;

abstract class Api
{
    protected $method = ''; //GET|POST|PUT|DELETE
    public $requestParams = [];
    protected $action = ''; //Название метод для выполнения
    protected $db;
    protected $token = 'li2j3fojewf';

    /**
     * Api constructor.
     */
    public function __construct() {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->requestParams = $_REQUEST;
        $this->db = new SafeMySQL();
    }

    /**
     * @return mixed
     */
    public function run() {

        $get = $this->requestParams;
        //Определение действия для обработки
        $this->action = $this->getAction();
        if (isset($get['token'])) {
            if ($get['token']==$this->token) {
                //Если метод(действие) определен в дочернем классе API
                if (method_exists($this, $this->action)) {
                    return $this->{$this->action}();
                } else {
                    throw new RuntimeException('Invalid Method', 405);
                }
            }
        }
        return $this->response('Data not found', 404);
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
        $action = $this->requestParams['action'];

        switch ($action) {
            case 'showpic':
                return 'viewAction';
                break;
            case 'setstatus':
                return 'statusAction';
                break;
            case 'add':
                return 'addAction';
                break;
            default:
                return null;
        }
    }

    /**
     * @return mixed
     */
    abstract protected function viewAction();

    /**
     * @return mixed
     */
    abstract protected function addAction();

    /**
     * @return mixed
     */
    abstract protected function statusAction();
}