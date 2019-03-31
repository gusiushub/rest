<?php

namespace app\models;


class Log
{
    public static $file = __DIR__.'/../log/log.log';
    public static $console_file = __DIR__.'/../log/console.log';

    /**
     * @return bool
     */
    public static function run()
    {
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                return self::get();
                break;
            case 'POST':
                return self::post();
                break;
        }
    }

    /**
     * @return bool
     */
    public static function post()
    {
        if (!empty($_POST)) {
            $fw = fopen(self::$file, "a");
            fwrite($fw, "POST " . var_export($_POST, true));
            fclose($fw);
            return true;
        }
    }

    /**
     * @return bool
     */
    public static function get()
    {
        if (!empty($_GET)) {
            $fw = fopen(self::$file, "a");
            fwrite($fw, "GET " . var_export($_GET, true));
            fclose($fw);
            return true;
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public static function consoleLog($data)
    {
        $fw = fopen(self::$console_file, "a");
        fwrite($fw, '['.date('Y.m.d H:i:s').'] - '. json_encode($data) . "\n");
        fclose($fw);
        return true;
    }

}