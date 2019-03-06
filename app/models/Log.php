<?php

namespace app\models;


class Log
{
    public static $file = __DIR__.'/../log/log.log';

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

    public static function post()
    {
        if (!empty($_POST)) {
            $fw = fopen(self::$file, "a");
            fwrite($fw, "POST " . var_export($_POST, true));
            fclose($fw);
            return true;
        }
    }

    public static function get()
    {
        if (!empty($_GET)) {
            $fw = fopen(self::$file, "a");
            fwrite($fw, "GET " . var_export($_GET, true));
            fclose($fw);
            return true;
        }
    }

    public static function cUrl()
    {

    }
}