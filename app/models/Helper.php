<?php

namespace app\models;


use app\db\SafeMySQL;

class Helper
{
    /**
     * @return array
     */
    public static function getConfig()
    {
        return require __DIR__.'/../config/config.php';
    }

    /**
     * @return mixed
     */
    public static function dir()
    {
        $config = self::getConfig();
        return $config['dir'];
    }

    /**
     * @return mixed
     */
    public static function dirImg()
    {
        $config = self::getConfig();
        return $config['img'];
    }

    /**
     * @return array
     */
    public static function getLetterByNum()
    {
        $arr = [
            1 => 'a',
            2 => 'b',
            3 => 'c',
            4 => 'd',
            5 => 'e',
            6 => 'f',
            7 => 'g',
            8 => 'h',
            9 => 'i',
            10 => 'j',
            11 => 'k',
            12 => 'l',
            13 => 'm',
            14 => 'n',
            15 => 'o',
            16 => 'p',
            17 => 'q',
            18 => 'r',
            19 => 's',
            20 => 't',
            21 => 'u',
            22 => 'v',
            23 => 'w',
            24 => 'x',
            25 => 'y',
            26 => 'z',
        ];

        return $arr;
    }

    /**
     * @param $name
     * @return int
     */
    public static function getLetter($name)
    {
        switch ($name) {
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

    /**
     * @param $filename
     * @return array
     */
    public static function getName($filename)
    {
        return str_split($filename);
    }

    /**
     * @param $filename
     * @return mixed
     */
    public static function getLastLetter($filename)
    {
        $arr = self::getName($filename);
        $count = count($arr);
        return $arr[$count-1];
    }

    /**
     * @param $fileName
     * @return string
     */
    public function nextLetter($fileName, $type = null)
    {
        $array = self::getLetterByNum();
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
                if ($type=='console') {
                    mkdir(__DIR__ . '/app/img/' . $fileName[0] . '/00' . $fileName[1], 0700);
                }
                return $fileName[0].'/00'.$fileName[1].'/'.$fileName[2].'.jpg';
            }
            if (iconv_strlen($fileName[1])==2){
                if ($type=='console') {
                    mkdir(__DIR__ . '/app/img/' . $fileName[0] . '/0' . $fileName[1], 0700);
                }
                return $fileName[0].'/0'.$fileName[1].'/'.$fileName[2].'.jpg';
            }
            if ($type=='console') {
                mkdir(__DIR__ . '/app/img/' . $fileName[0] . '/' . $fileName[1], 0700);
            }
            return $fileName[0].'/'.$fileName[1].'/'.$fileName[2].'.jpg';
        }elseif($fileName[1]>998 && $fileName[2]>997){

            $numLetter = self::getLetter(self::getLastLetter($fileName[0]));
            $arr = self::getName($fileName[0]);
            $count = count($arr);
            if ($numLetter!=26){
                $arr[$count-1]=$array[$numLetter+1];
                if ($type=='console') {
                    mkdir(__DIR__ . '/app/img/' . implode($arr), 0700);
                    mkdir(__DIR__ . '/app/img/' . implode($arr) . '/000/', 0700);
                }
                return implode($arr).'/000/000.jpg';
            }else{
                $arrLet = array();
                for ($i=0;$i<$count+1;$i++){
                    $arrLet[$i]='a';
                }
                if ($type=='console') {
                    mkdir(__DIR__ . '/app/img/' . implode($arrLet), 0700);
                    mkdir(__DIR__ . '/app/img/' . implode($arrLet) . '/000/', 0700);
                }
                return implode($arrLet).'/000/000.jpg';
            }
        }
    }

    /**
     * @param $folder
     */
    public function showTree($folder) {
        /* Получаем полный список файлов и каталогов внутри $folder */
        $files = scandir($folder);

        foreach($files as $file) {
            /* Отбрасываем текущий и родительский каталог */
            if (($file == '.') || ($file == '..')) continue;

            $f0 = $folder.'/'.$file; //Получаем полный путь к файлу
            $fileName = file_get_contents(self::dir());
            /* Если это директория */
            if (is_dir($f0)) {
                $this->copy($file,$this->showTree($f0), self::dirImg().$fileName);
            }
            $this->copy($file,$f0,self::dirImg().$fileName);

            file_put_contents(self::dir(), $this->nextLetter($fileName,'console'));
        }
    }

    /**
     * @param $filename
     * @param $dirFile
     * @param $dirToCopy
     */
    private function copy($filename, $dirFile, $dirToCopy)
    {
        $db = new SafeMySQL();
        if (!empty($dirFile) && !empty($dirToCopy)) {
            if (!copy($dirFile, $dirToCopy)) {
                unlink($dirFile);
                echo "не удалось скопировать $filename...\n";
            } else {
                $db->query("INSERT INTO avatars (name, new_path) VALUES ('" . $filename . "','/" . $dirToCopy . "')");
                unlink($dirFile);
            }
        }
    }
}