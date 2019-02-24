<?php
use app\db\SafeMySQL;
require_once 'app/db/SafeMySQL.php';
showTree('./incoming');


/**
 * @param $fileName
 * @return string
 */
function nextLetter($fileName)
{
    $array = getL();
    $fileName = explode('/',$fileName);
    $partName = explode('.',$fileName[2]);
    $fileName[2] = $partName[0] ;
    if ($fileName[2]<998){
        $fileName[2]++;
        if (iconv_strlen($fileName[2])==1){

            return $fileName[0].'/'.$fileName[1].'/00'.$fileName[2].'.jpg';
        }
        if (iconv_strlen($fileName[2])==2){

            return $fileName[0].'/'.$fileName[1].'/0'.$fileName[2].'.jpg';
        }

        return $fileName[0].'/'.$fileName[1].'/'.$fileName[2].'.jpg';

    }elseif($fileName[1]<998 && $fileName[2]>997){
        $fileName[1]++;
        $fileName[2]='000';
        if (iconv_strlen($fileName[1])==1){
            mkdir(__DIR__.'/app/img/'.$fileName[0].'/00'.$fileName[1],0700);
            return $fileName[0].'/00'.$fileName[1].'/'.$fileName[2].'.jpg';
        }
        if (iconv_strlen($fileName[1])==2){
            mkdir(__DIR__.'/app/img/'.$fileName[0].'/0'.$fileName[1],0700);
            return $fileName[0].'/0'.$fileName[1].'/'.$fileName[2].'.jpg';
        }
        mkdir(__DIR__.'/app/img/'.$fileName[0].'/'.$fileName[1],0700);

        return $fileName[0].'/'.$fileName[1].'/'.$fileName[2].'.jpg';
    }elseif($fileName[1]>998 && $fileName[2]>997){

        $numLetter = getLetter(getLastLetter($fileName[0]));
        $arr = getName($fileName[0]);
        $count = count($arr);
        if ($numLetter!=26){
            $arr[$count-1]=$array[$numLetter+1];
            mkdir(__DIR__.'/app/img/'.implode($arr),0700);
            mkdir(__DIR__.'/app/img/'.implode($arr).'/000/',0700);
            return implode($arr).'/000/000.jpg';
        }else{
            $arrLet = array();
            for ($i=0;$i<$count+1;$i++){
                $arrLet[$i]='a';
            }
            mkdir(__DIR__.'/app/img/'.implode($arrLet),0700);
            mkdir(__DIR__.'/app/img/'.implode($arrLet).'/000/',0700);
            return implode($arrLet).'/000/000.jpg';
        }
    }
}


/**
 * @param $filename
 */
function compareLetter($filename)
{
    $numLast = getLetter(getLastLetter($filename));
    $arr = getL();
    if ($numLast!=1) {
        $noLast = $arr[$numLast - 1];
    }
}

/**
 * @param $folder
 */
function showTree($folder) {
    /* Получаем полный список файлов и каталогов внутри $folder */
    $files = scandir($folder);
    $opts = array(
            'user'    => 'root',
            'pass'    => '',
            'db'      => 'rest',
            'charset' => 'utf8'

        );

        $db= new SafeMySQL($opts);
    foreach($files as $file) {
        /* Отбрасываем текущий и родительский каталог */
        if (($file == '.') || ($file == '..')) continue;
        $f0 = $folder.'/'.$file; //Получаем полный путь к файлу
        /* Если это директория */
        if (is_dir($f0)) {
            $fileName = file_get_contents(__DIR__.'/dir.txt');
            file_put_contents(__DIR__.'/dir.txt', nextLetter($fileName));
            if (!copy(showTree($f0), './../app/img/'.$fileName)) {
                unlink(showTree($f0));
                echo "не удалось скопировать $file...\n";
            }else {
$avatars = $db->query("INSERT INTO avatars (name, new_path) VALUES ('".$file."','./../app/img/".$fileName."')");
                unlink(showTree($f0));
            }
        }
        $fileName = file_get_contents(__DIR__.'/dir.txt');
        file_put_contents(__DIR__.'/dir.txt', nextLetter($fileName));
        if (!copy($f0, './app/img/'.$fileName)) {
            unlink($f0);
            echo "не удалось скопировать $file...\n";
        }else{
            $avatars = $db->query("INSERT INTO avatars (name, new_path) VALUES ('".$file."','./../app/img/".$fileName."')");
            unlink($f0);
        }
    }
}


/**
 * @param $filename
 * @return array
 */
function getName($filename)
{
    return str_split($filename);
}

/**
 * @param $filename
 * @return mixed
 */
function getLastLetter($filename)
{
    $arr = getName($filename);
    $count = count($arr);
    return $arr[$count-1];
}

/**
 * @return array
 */
function getL()
{
    $arr = [
        1=>'a',
        2=>'b',
        3=>'c',
        4=>'d',
        5=>'e',
        6=>'f',
        7=>'g',
        8=>'h',
        9=>'i',
        10=>'j',
        11=>'k',
        12=>'l',
        13=>'m',
        14=>'n',
        15=>'o',
        16=>'p',
        17=>'q',
        18=>'r',
        19=>'s',
        20=>'t',
        21=>'u',
        22=>'v',
        23=>'w',
        24=>'x',
        25=>'y',
        26=>'z',
    ];

    return $arr;
}

/**
 * @param $name
 * @return int
 */
function getLetter($name)
{
    switch ($name){
        case 'a':
            return 1;
        break;
        case 'b':
            return 2;
            break;
        case 'c':
            return 3;
            break;
        case 'd':
            return 4;
            break;
        case 'e':
            return 5;
            break;
        case 'f':
            return 6;
            break;
        case 'g':
            return 7;
            break;
        case 'h':
            return 8;
            break;
        case 'i':
            return 9;
            break;
        case 'j':
            return 10;
            break;
        case 'k':
            return 11;
            break;
        case 'l':
            return 12;
            break;
        case 'm':
            return 13;
            break;
        case 'n':
            return 14;
            break;
        case 'o':
            return 15;
            break;
        case 'p':
            return 16;
            break;
        case 'q':
            return 17;
            break;
        case 'r':
            return 18;
            break;
        case 's':
            return 19;
            break;
        case 't':
            return 20;
            break;
        case 'u':
            return 21;
            break;
        case 'v':
            return 22;
            break;
        case 'w':
            return 23;
            break;
        case 'x':
            return 24;
            break;
        case 'y':
            return 25;
            break;
        case 'z':
            return 26;
    }
}