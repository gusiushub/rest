<?php
/**
 * временный файл для включения
 * ошибок на время разработки
 * удалить при релизе(отключить в точке входа)
 */

namespace app\models;

class Debug
{
    public static function D($status)
    {
        if ($status=='dev'){
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
        }
    }

    public static function dump($str){
        echo '<pre>';
        var_dump($str);
        echo '</pre>';
        exit;
    }
}