<?php

namespace app\models;


use app\db\SafeMySQL;

class Helper
{

    public static $bio = __DIR__ . '/../../bio.txt';
    public static $ip = __DIR__ . '/../../ip.txt';
    /**
     * @return array
     */
    public static function getConfig()
    {
        return require __DIR__.'/../config/config.php';
    }

    public static function config()
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
     * @param $filename
     * @return array
     */
    public static function getName($filename)
    {
        return str_split($filename);
    }

    private static function getArr($file)
    {
        return file($file,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    }
    /**
     * @return mixed
     */
    public static function getStr($file)
    {
        $bio = self::getArr($file);

//        var_dump($bio); exit;
        $i=0;
        $str = '';

        while (empty($bio[$i]) or $bio[$i]=='' or trim($bio[$i])=='---'){
//            if (self::delStr(self::$bio)){
            if (self::delStr($file)){
                $i++;
            }
        }
        self::delStr($file);
//        self::delStr(self::$bio);
//        }
//        $i=0;
//            if (trim($bio[$i])=='---'){
//                self::delStr(__DIR__ . '/../../bio.txt');
//            }
        while (trim($bio[$i])!='---') {
//            if (self::delStr(self::$bio)) {
            if (self::delStr($file)) {
                $str = $str . $bio[$i];
                $i++;
            }
        }
//        self::delStr(self::$bio);
        self::delStr($file);
        $string = str_replace("'"," ",$str);
        return $string;
    }

    /**
     * @param $start
     * @param $end
     * @param $str
     * @return mixed
     */
    public static function getInbetweenStrings($start, $end, $str){
        $matches = array();
        $regex = "/$start([a-zA-Z0-9_]*)$end/";
        preg_match_all($regex, $str, $matches);
        return $matches[0];
    }

    /**
     * @return mixed
     */
    public static function getBio()
    {
        $str = self::getStr(self::$bio);

        $search = self::getInbetweenStrings('%','%',$str);
        if (!empty($search)) {
            $val = array(self::getFullname($_GET['fullname']), $_GET['sex'], $_GET['country'], $_GET['age']);
            if (preg_match("/%(.*?)%/", $str, $matches))
                $newphrase = str_replace($search, $val, $str);
//        $file=__DIR__.'/../../bio.txt';
//        self::delStr($file);

//        $filearray=file($file);
//        if (trim($filearray[0])=='---'){
//            self::delStr($file);
//        }

            return $newphrase;
        }

        return $str;
    }

    /**
     * @param $db
     * @param int $from
     * @param int $to
     * @return bool|int
     */
    public static function getPort($db, $from=24001, $to=24250)
    {
        $port = rand($from, $to);
        $query = "SELECT ip FROM ip GROUP BY ip HAVING count(*)>3;";// where ip='".$str[$i]."' limit 5";
        $result = $db->getAll($query);
        if (isset($result)){

        foreach ($result as $res){
            if(array_search($port,$res)==false){
//
                return $port;
            }
        }
        return false;
        }
        return $port;
    }

    /**
     * @param $db
     * @param int $i
     * @return array
     */
    public static function getIp($db, $i=0)
    {
        $str = self::getArr(self::$ip);
        $query = "SELECT ip FROM ip GROUP BY ip HAVING count(*)>3;";// where ip='".$str[$i]."' limit 5";
        $result = $db->getAll($query);
        foreach ($result as $res){
            if(($key = array_search($res['ip'],$str)) !== FALSE){
                unset($str[$key]);
            }
        }

        if (isset($result)){
            return [
                'ok'=>$str[array_rand($str, 1)],
                'error'=>$result
            ];
        }
            return ['ok' => $str[array_rand($str, 1)]];
    }

    /**
     *
     */
    public static function delStr($file)
    {
        $filearray=file($file);
        if(is_array($filearray))
        {
            $f=fopen($file,'w');
            for($i=1;$i<sizeof($filearray);$i++)
            {
                fwrite($f,$filearray[$i]);
            }
            fclose($f);
            return true;
        }
        return false;
    }

    /**
     * @param $url
     * @param $arrPost
     */
    public static function sendPost($url, $arrPost)
    {

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $arrPost);
            $out = curl_exec($curl);
            if ($out === FALSE) {
                //Тут-то мы о ней и скажем
                echo "cURL Error: " . curl_error($curl);
                return;
            }
            echo $out;
            curl_close($curl);
        }
    }


    /**
     * @param $fullname
     * @return mixed
     */
    private static function getFullname($fullname)
    {
        $arr = explode(' ', trim($fullname));

        $randName = array();
        $randName[] = $arr[0].' '.$arr[1].' '.$arr[2];
        $randName[] = $arr[1];
        $num = mt_rand(0, count($randName) - 1);
        return $randName[$num];
    }
}