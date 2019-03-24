<?php

use app\models\Helper;


require_once 'app/db/SafeMySQL.php';
require_once 'app/models/Helper.php';

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


