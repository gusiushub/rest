<?php

use app\api\UserApi;

include '../vendor/autoload.php';
require_once 'api/UserApi.php';

try {
    $api = new UserApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}