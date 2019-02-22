<?php
$files = scandir(__DIR__.'/incoming/ff');
//mkdir(__DIR__.'/incoming/ff',0700);

$arr =[];
 $fileName = file_get_contents(__DIR__.'/dir.txt');
var_dump($fileName);
var_dump(nextLetter($filename));
file_put_contents(__DIR__.'/dir.txt', nextLetter($fileName));

var_dump(nextLetter('sdfsdf'));
//for($i=0;$i<$count;$i++){
function isPlusLetter()
{

}

function nextLetter($fileName)
{
    $array = getL();
    $numLetter = getLetter(getLastLetter($fileName));
    $arr = getName($fileName);
    $count = count($arr);
    if ($numLetter!=26){
        $arr[$count-1]=$array[$numLetter+1];
        return implode($arr);
    }else{
        $arrLet = array();
        for ($i=0;$i<$count+1;$i++){
            $arrLet[$i]='a';
        }
//        $arrLet[$count]=
        return implode($arrLet);
    }
//    $newLetter = $array[getLetter(getLastLetter($fileName))+1];
}
//    var_dump();
    var_dump($arr[$count-1]=$newLetter);

function compareLetter($filename)
{
    $last = getLastLetter($filename);
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
            $fileName = file_get_contents('./dir.txt');
            file_put_contents('./dir',$fileName.'dsf');
            if (!copy(showTree($f0), './app/img/'.$fileName)) {
                echo "не удалось скопировать $file...\n";
            }
        }
        $fileName = file_get_contents('./dir.txt');
        file_put_contents('./dir',$fileName.'dsf');
        if (!copy($file, './app/img/'.$fileName)) {
            echo "не удалось скопировать $file...\n";
        }
        /* Если это файл, то просто выводим название файла */
//        else echo $file."<br />";
    }
}
/* Запускаем функцию для текущего каталога */
//showTree("./incoming", "");

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