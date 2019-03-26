<?php

use app\models\Helper;
use app\db\SafeMySQL;
//use app\api\UserApi;
//use app\api\Api;


require_once 'app/db/SafeMySQL.php';
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
    for ($i=24001; $i<24250; $i++){
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
//    var_dump($row); exit;
    foreach ($row as $value){
        $db->query("UPDATE users SET Bio='".Helper::getBio()."' WHERE id=".$value['id'].";");
    }
}

if ($argv[1]=='sendavatar') {
    $db = new \app\db\SafeMySQL();
    $row = $db->getAll('SELECT * FROM users;');
//    $userApi = new UserApi;
    foreach ($row as $value){
//        $send =
            sendAvatar($value['Profilepicture'],$value['id']);
//        var_dump($send); exit;
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
 * @param $file
 * @param $userId
 */
function sendAvatar($file, $userId)
{
    $postfields = array();
    // тут путь к картинке, которая будет отправляться
    $file = __DIR__ . '/incoming/' . $file;
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // возвращает mime-тип
    $mime = finfo_file($finfo, $file);
    finfo_close($finfo);
    $curlFile = curl_file_create($file, $mime, basename($file));
    $postfields['image'] = $curlFile;
    $postfields['id_profile'] = $userId;
    $url = 'http://104.248.82.215/sfparser.php';
    $headers = array("Content-Type" => "multipart/form-data");
    return sendRequestInService(array('url' => $url, 'headers' => $headers, 'postfields' => $postfields));
}


