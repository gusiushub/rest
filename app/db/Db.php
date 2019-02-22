<?php

namespace app\db;

use app\api\SafeMySQL;

//require_once 'db/SafeMySQL.php';
class Db extends SafeMySQL
{
    public $db;


    public function __Db()
    {
        $opts = array(
            'user'    => 'root',
            'pass'    => '',
            'db'      => 'rest',
            'charset' => 'utf-8'

        );
//        $this->db =
        return new SafeMySQL($opts);
    }
}