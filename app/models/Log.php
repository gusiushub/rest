<?php

namespace app\models;


class Log
{
    public static $file = __DIR__.'/../log/log.log';

    public static function run()
    {
        self::get();
        self::post();
    }

    public static function post()
    {
        if (!empty($_POST)) {
            $fw = fopen(self::$file, "a");
            fwrite($fw, "POST " . var_export($_POST, true));
            fclose($fw);
        }
    }

    public static function get()
    {
        if (!empty($_GET)) {
            $fw = fopen(self::$file, "a");
            fwrite($fw, "GET " . var_export($_GET, true));
            fclose($fw);
        }
    }
}