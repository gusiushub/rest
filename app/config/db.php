<?php
$host ='localhost';
$login ='root';
$password ='';
$dbname ='rest';

return [
    'host' => $host,
    'user' => $login,
    'pass' => $password,
    'db' => $dbname,
    'port'      => NULL,
    'socket'    => NULL,
    'pconnect'  => FALSE,
    'charset'   => 'utf8',
    'errmode'   => 'exception', //or 'error'
    'exception' => 'Exception', //Exception class name
];