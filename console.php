<?php

use app\models\Helper;
use app\db\SafeMySQL;
use app\models\Log;
//use app\api\UserApi;
//use app\api\Api;
require __DIR__.'/vendor/autoload.php';

//require_once 'app/db/SafeMySQL.php';
require_once 'app/models/Helper.php';
//require __DIR__.'/app/api/UserApi.php';

if ($argv[1]=='rename') {
    switch ($argv[2]) {
        case 'Male':
            $folder = __DIR__ . '/incoming/Male'; //Папка с файлами
            break;
        case 'Female':
            $folder = __DIR__ . '/incoming/Female'; //Папка с файлами
            break;
    }

    $array_file = scandir($folder); //Масcив с именами файлов

    $i = 1;
    foreach ($array_file as $name_file) {
        if (($name_file == '.') || ($name_file == '..')) continue;

        if (!is_dir($folder . '/' . $name_file)) {
            $new_name = str_pad($i, 4, "0", STR_PAD_LEFT);
            if (rename($folder . '/' . $name_file, $folder . '/' . $new_name . '.jpg')) {
                $i++;
            } else {
                echo "Ошибка переименования файла $name_file<br/>";
            }
        }
    }
}

if ($argv[1]=='setport') {
    $db = new \app\db\SafeMySQL();
    for ($i=24250; $i<24500; $i++){
        $db->query("INSERT INTO port ( name,  count) VALUES (".$i.", 0)");
    }
}

if ($argv[1]=='count') {
    $db = new \app\db\SafeMySQL();
    $row = $db->getAll('SELECT * FROM ip;');
    foreach ($row as $value){
        $db->query("UPDATE port SET count=count+1 WHERE name=".(int)$value['ip'].";");
    }
}

if ($argv[1]=='updatebio') {
    $db = new \app\db\SafeMySQL();
    $row = $db->getAll("SELECT * FROM users where Bio='I m working as a salesperson.Healthy Lifestyle [love]Olay, Сeline and [love] The future belongs to those, who believe of their dreams.';");
    foreach ($row as $value){
        $db->query("UPDATE users SET Bio='".Helper::getBio()."' WHERE id=".$value['id'].";");
    }
}

if ($argv[1]=='sendavatar') {
    $db = new SafeMySQL();
    $row = $db->getAll('SELECT * FROM users group by id desc;');

    foreach ($row as $value) {

            $response = sendAvatar('Female/00047.jpg',101);
            var_dump($response);
            exit;
//            $response = sendAvatar($value['Profilepicture'],$value['id']);
            if ($response == 104) {
                echo $response."\n";
                break;
            }
            echo $response."\n";

    }
}

if ($argv[1]=='useport') {
    $db = new \app\db\SafeMySQL();
    $row = $db->getAll('SELECT * FROM port');
    foreach ($row as $value){
//        $users = $db->getAll("SELECT * FROM users WHERE ip='".$value['name']."'");
            $users = $db->getAll("SELECT * FROM users WHERE ip=24095;");
var_dump($users); exit;
        if ($users){
            if (count($users)<4){
//                $db->query("UPDATE port SET count=".count($users)." WHERE name=24023;");
                $db->query("UPDATE port SET count=".count($users)." WHERE name=".$value['name'].";");
//                var_dump(count($users));
            }
        }

    }
}

function sendRequestInService($params)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$params['url']);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $params['headers']);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params['postfields']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $response = curl_exec($ch);
    if (!curl_errno($ch)) {
        $info = curl_getinfo($ch);
        if ($info['http_code'] == 200 && !empty($response)) {
            $response = json_decode($response);
        }
    }
    curl_close($ch);
    return $response;
}

/**
 * @param $fileName
 * @param $userId
 * @return mixed
 */
function sendAvatar($fileName, $userId)
{
    $db = new \app\db\SafeMySQL();
    $postfields = array();
    // тут путь к картинке, которая будет отправляться
    $file = __DIR__ . '/incoming/' . $fileName;
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // возвращает mime-тип
    $mime = finfo_file($finfo, $file);
    finfo_close($finfo);
    $curlFile = curl_file_create($file, $mime, basename($file));
    $postfields['image'] = $curlFile;
    $postfields['id_profile'] = $userId;
    $url = 'http://104.248.82.215/sfparser.php';
    $headers = array("Content-Type" => "multipart/form-data");
    $response = sendRequestInService(array('url' => $url, 'headers' => $headers, 'postfields' => $postfields));
    $db->query("UPDATE users SET is_sf=".$response." WHERE id=" . (int)$userId . ";");
//    $db->query("UPDATE users SET is_sf=?s WHERE id=" . (int)$userId . ";", $response);
    Log::consoleLog(['userId' => $userId, 'filename' => $fileName, 'response' => $response]);
    return $response;
}


function cron()
{
    $db = new \app\db\SafeMySQL();
    $time = time()-60*60;
    $db->query("UPDATE users SET Used=0 WHERE Used=1 AND Useddate<".$time);
}

if ($argv[1]=='cron') {
    cron();
}


