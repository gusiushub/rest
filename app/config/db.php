<?php
$host ='localhost';
//$host ='134.209.88.94';
$login ='root';
$password ='';
//$password ='0094#avatars';
$dbname ='rest';

return [
    'host' => $host,
    'user' => $login,
    'pass' => $password,
    'db' => $dbname,
    'port'      => 3306,
    'socket'    => NULL,
    'pconnect'  => FALSE,
    'charset'   => 'utf8',
    'errmode'   => 'exception', //or 'error'
    'exception' => 'Exception', //Exception class name
];