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
     * @param $filename
     * @return string
     */
    public static function  nextLetter($filename, $type = null)
    {
        $array = self::getLetterByNum();
        $filename = explode('/',$filename);
        $partName = explode('.',$filename[2]);
        $filename[2] = $partName[0] ;
        if ($filename[2]<998){
            $filename[2]++;
            if (iconv_strlen($filename[2])==1){

                return $filename[0].'/'.$filename[1].'/00'.$filename[2].'.jpg';
            }
            if (iconv_strlen($filename[2])==2){

                return $filename[0].'/'.$filename[1].'/0'.$filename[2].'.jpg';
            }

            return $filename[0].'/'.$filename[1].'/'.$filename[2].'.jpg';

        }elseif($filename[1]<998 && $filename[2]>997){
            $filename[1]++;
            $filename[2]='000';
            if (iconv_strlen($filename[1])==1){
                if ($type=='console') {
                    mkdir(self::dirImg() . $filename[0] . '/00' . $filename[1], 0700);
                }
                return $filename[0].'/00'.$filename[1].'/'.$filename[2].'.jpg';
            }
            if (iconv_strlen($filename[1])==2){
                if ($type=='console') {
                    mkdir(self::dirImg() . $filename[0] . '/0' . $filename[1], 0700);
                }
                return $filename[0].'/0'.$filename[1].'/'.$filename[2].'.jpg';
            }
            if ($type=='console') {
                mkdir(self::dirImg() . $filename[0] . '/' . $filename[1], 0700);
            }
            return $filename[0].'/'.$filename[1].'/'.$filename[2].'.jpg';
        }elseif($filename[1]>998 && $filename[2]>997){

            $numLetter = self::getLetter(self::getLastLetter($filename[0]));
            $arr = self::getName($filename[0]);
            $count = count($arr);
            if ($numLetter!=26){
                $arr[$count-1]=$array[$numLetter+1];
                if ($type=='console') {
                    mkdir(self::dirImg() . implode($arr), 0700);
                    mkdir(self::dirImg() . implode($arr) . '/000/', 0700);
                }
                return implode($arr).'/000/000.jpg';
            }else{
                $arrLet = array();
                for ($i=0;$i<$count+1;$i++){
                    $arrLet[$i]='a';
                }
                if ($type=='console') {
                    mkdir(self::dirImg() . implode($arrLet), 0700);
                    mkdir(self::dirImg() . implode($arrLet) . '/000/', 0700);
                }
                return implode($arrLet).'/000/000.jpg';
            }
        }
    }

    /**
     * @param $folder
     */
    public static function showTree($folder) {
        $files = scandir($folder);

        foreach($files as $file) {
            if (($file == '.') || ($file == '..')) continue;

            $f0 = $folder.'/'.$file; //Получаем полный путь к файлу
            $filename = file_get_contents(self::dir());

            if (is_dir($f0)) {
                self::copy($file,self::showTree($f0), self::dirImg().$filename);
            }
            self::copy($file,$f0,self::dirImg().$filename);
            file_put_contents(self::dir(), self::nextLetter($filename,'console'));
        }
    }

    /**
     * @param $filename
     * @param $dirFileOld
     * @param $dirFileNew
     */
    private static function copy($filename, $dirFileOld, $dirFileNew)
    {
        $db = new SafeMySQL();
        if (!empty($dirFileOld) && !empty($dirFileNew)) {
            if (!copy($dirFileOld, $dirFileNew)) {

                unlink($dirFileOld);
                rmdir($dirFileOld);
                echo "не удалось скопировать $filename...\n";
            } else {
                $newName = explode('/',$dirFileNew);
//                var_dump($newName);
                $db->query("INSERT INTO avatars (old_name,new_name, old_path, new_path, flag) VALUES ('" . $filename . "','" . $newName[5] . "','" . $dirFileOld . "','" . $dirFileNew . "',0)");
                unlink($dirFileOld);
            }
        }
    }

    /**
     * @return mixed
     */
    public static function getBio()
    {
        $bio = file('bio.txt',FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
        return $bio[0];
    }

    public static function getInbetweenStrings($start, $end, $str){
        $matches = array();
        $regex = "/$start([a-zA-Z0-9_]*)$end/";
        preg_match_all($regex, $str, $matches);
//        var_dump(array_walk($matches[1], self::arr($matches[1])));
        return $matches[0];
//        var_dump($matches[0]);
//        return array_walk($matches[0], '%'.$matches[0].'%');
    }

    public static function arr(&$arr)
    {
//        function myFunc(&$arr) {
            $arr = '<strong>'.$arr.'</strong>';

    }
    public static function bio()
    {
//        var_dump(self::getInbetweenStrings('%','%',self::getBio()));
//        exit;
        // присваивает: You should eat pizza, beer, and ice cream every day
//        $phrase  = "You should eat fruits, vegetables, and fiber every day.";
        $search = self::getInbetweenStrings('%','%',self::getBio());
//        var_dump($search);
//        $search = array("%name%", "%sex%", "%country%, %age%");
        $val   = array($_GET['fullname'], $_GET['sex'], $_GET['country'], $_GET['age']);
        if(preg_match("/%(.*?)%/",self::getBio(),$matches))
            $text1 = $matches;
        $newphrase = str_replace($search, $val, self::getBio());
        self::delStr();
        $file=__DIR__.'/../../bio.txt';
        $filearray=file($file);
        if (trim($filearray[0])=='---'){
            self::delStr();
        }
        var_dump($filearray);
        exit;

    }

    public static function delStr()
    {
        $file=__DIR__.'/../../bio.txt';
        $filearray=file($file);
        var_dump($filearray);
        if(is_array($filearray))
        {
            $f=fopen($file,'w');
            for($i=1;$i<sizeof($filearray);$i++)
            {
                fwrite($f,$filearray[$i]);
            }
            fclose($f);
        }
    }
}