<?php

$arr =[];
var_dump(showTree('./incoming'));


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


function compareLetter($filename)
{
    $numLast = getLetter(getLastLetter($filename));
    $arr = getL();
    if ($numLast!=1) {
        $noLast = $arr[$numLast - 1];
    }
}

function showTree($folder) {
    /* Получаем полный список файлов и каталогов внутри $folder */
    $files = scandir($folder);
    foreach($files as $file) {
        /* Отбрасываем текущий и родительский каталог */
        if (($file == '.') || ($file == '..')) continue;
        $f0 = $folder.'/'.$file; //Получаем полный путь к файлу
        /* Если это директория */
        if (is_dir($f0)) {
            $fileName = file_get_contents(__DIR__.'/dir.txt');
            file_put_contents(__DIR__.'/dir.txt', nextLetter($fileName));
            if (!copy(showTree($f0), './../app/img/'.$fileName)) {
                echo "не удалось скопировать $file...\n";
            }
        }
        $fileName = file_get_contents(__DIR__.'/dir.txt');
        file_put_contents(__DIR__.'/dir.txt', nextLetter($fileName));
        if (!copy('./incoming/'.$file, './app/img/'.$fileName)) {
            echo "не удалось скопировать $file...\n";
        }

    }
}


function getName($filename)
{
    return str_split($filename);
}

function getLastLetter($filename)
{
    $arr = getName($filename);
    $count = count($arr);
    return $arr[$count-1];
}

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