<?php

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
        if(rename($folder.'/'.$name_file, $folder.'/'.$new_name)){
            $i++;
//                echo "Файл $name_file переименован<br/>";
        }else{
            echo "Ошибка переименования файла $name_file<br/>";
        }
    }
}


