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
        $this->action = $this->getAction();
        if (isset($get['token'])) {
            if ($get['token']==$this->token) {
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
            case 'log':
                return 'logAction';
                break;
            case 'ip':
                return 'ipAction';
                break;
            case 'bio':
                return 'bioAction';
                break;
            case 'avatar':
                return 'avatarAction';
                break;
            case 'csv':
                return 'csvAction';
                break;
            case 'postcount':
                return 'postcountAction';
                break;
            case 'dashboard':
                return 'dashboardAction';
                break;
            case 'useridbylogin':
                return 'useridbyloginAction';
                break;
            case 'userbystatus':
                return 'userbystatusAction';
                break;
            case 'getuser':
                return 'getuserAction';
                break;
            default:
                return null;
        }
    }


    /**
     * Создает CSV файл из переданных в массиве данных.
     * @param array  $create_data  Массив данных из которых нужно созать CSV файл.
     * @param string $file         Путь до файла 'path/to/test.csv'. Если не указать, то просто вернет результат.
     * @return string/false        CSV строку или false, если не удалось создать файл.
     * ver 2
     */
    public function kama_create_csv_file( $create_data, $file = null, $col_delimiter = ';', $row_delimiter = "\r\n\r\n" ){

        if( ! is_array($create_data) )
            return false;

        if( $file && ! is_dir( dirname($file) ) )
            return false;

        // строка, которая будет записана в csv файл
        $CSV_str = '';

        // перебираем все данные
        foreach( $create_data as $row ){
            $cols = array();

            foreach( $row as $col_val ){
                // строки должны быть в кавычках ""
                // кавычки " внутри строк нужно предварить такой же кавычкой "
                if( $col_val && preg_match('/[",;\r\n]/', $col_val) ){
                    // поправим перенос строки
                    if( $row_delimiter === "\r\n" ){
                        $col_val = str_replace( "\r\n", '\n', $col_val );
                        $col_val = str_replace( "\r", '', $col_val );
                    }
                    elseif( $row_delimiter === "\n" ){
                        $col_val = str_replace( "\n", '\r', $col_val );
                        $col_val = str_replace( "\r\r", '\r', $col_val );
                    }

                    $col_val = str_replace( '"', '""', $col_val ); // предваряем "
                    $col_val = '"'. $col_val .'"'; // обрамляем в "
                }

                $cols[] = $col_val; // добавляем колонку в данные
            }

            $CSV_str .= implode( $col_delimiter, $cols ) . $row_delimiter; // добавляем строку в данные
        }
        $CSV_str = rtrim( $CSV_str, $row_delimiter );
        // задаем кодировку windows-1251 для строки
        if( $file ){
            $CSV_str = iconv( "UTF-8", "cp1251",  $CSV_str );
            // создаем csv файл и записываем в него строку
            $done = file_put_contents( $file, $CSV_str );
            return $done ? $CSV_str : false;
        }

        return $CSV_str;

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

    /**
     * @return mixed
     */
    abstract protected function logAction();

    /**
     * @return mixed
     */
    
    /**

     * @return mixed
     */
    abstract protected function ipAction();

    /**
     * @return mixed
     */
    abstract protected function bioAction();

    /**
     * @return mixed
     */
    abstract protected function avatarAction();

    /**
     * @return mixed
     */
    abstract protected function csvAction();

    /**
     * @return mixed
     */
    abstract protected function dashboardAction();

    /**
     * @return mixed
     */
    abstract protected function postcountAction();

    /**
     * @return mixed
     */
    abstract protected function useridbyloginAction();

    /**
     * @return mixed
     */
    abstract protected function userbystatusAction();

    /**
     * @return mixed
     */
    abstract protected function getuserAction();
//    abstract protected function getuserAction();
}