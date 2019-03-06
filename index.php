<?php

use app\api\UserApi;
use app\models\Log;
use app\models\Debug;

require __DIR__.'/vendor/autoload.php';
//var_dump(\app\models\Helper::getBio());



try {
//    Log::D('dev');
    Log::run();
    $api = new UserApi();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}