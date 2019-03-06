<?php
use app\models\Helper;


require_once 'app/db/SafeMySQL.php';
require_once 'app/models/Helper.php';
switch ($argv[1]){
    case 'Male':
        $folder = __DIR__.'/incoming/Male'; //Папка с файлами
        break;
    case 'Female':
        $folder = __DIR__.'/incoming/Female'; //Папка с файлами
        break;
}

$array_file = scandir($folder); //Масcив с именами файлов

$i = 1;
foreach($array_file as $name_file){
    if (($name_file == '.') || ($name_file == '..')) continue;

    if (!is_dir($folder.'/'.$name_file)){
        $new_name = str_pad ($i, 4,"0",STR_PAD_LEFT);
        if(rename($folder.'/'.$name_file, $folder.'/'.$new_name.'.jpg')){
            $i++;

//            $config = require __DIR__.'/app/config/config.php';
//            $helper = new Helper();
//            if ($new_name>9999){
//                mkdir(self::dirImg() . $filename[0] . '/00' . $filename[1], 0700);
//            }
//            Helper::copy($new_name,$folder.'/'.$name_file,'app/img/'.$new_name);
//                echo "Файл $name_file переименован<br/>";
        }else{
            echo "Ошибка переименования файла $name_file<br/>";
        }
    }
}


