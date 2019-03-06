<?php

use app\api\UserApi;
use app\models\Log;

require __DIR__.'/vendor/autoload.php';

try {
    Log::run();
    $api = new UserApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}