<?php

use app\api\UserApi;

require_once 'api/UserApi.php';

try {
    $api = new UserApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}