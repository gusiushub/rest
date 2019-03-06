<?php

ini_set('display_errors','On');
error_reporting('E_ALL');
//use app\api\UserApi;

require __DIR__.'/vendor/autoload.php';
//var_dump(\app\models\Helper::bio());
var_dump(\app\models\Log::run());
?>

<form method="post" >
    <input type="submit">
    <input type="text" name="asd">
</form>

<?php
exit;
try {
    $api = new UserApi();
    echo $api->run();
//    echo 1; exit;
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}