<?php

use app\api\UserApi;

require __DIR__.'/../vendor/autoload.php';

try {
    $api = new UserApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}