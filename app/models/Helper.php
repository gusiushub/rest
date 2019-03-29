<?php

namespace app\models;

use app\db\SafeMySQL;


class Helper
{
    public static $bio = __DIR__ . '/../../bio.txt';
    public static $ip = __DIR__ . '/../../ip.txt';
    const config = __DIR__ . '/../config/config.php';


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


    /**
     * @param $file
     * @return array|bool
     */
    private static function getArr($file)
    {
        return file($file,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    }

    /**
     * @param $string
     * @return null|string|string[]
     */
    public static function delSmile($string)
    {
        return preg_replace("/\[[^)]+\]/","",$string);
    }

    /**
     * @param $string
     * @return string
     */
    public static function cutStr($string)
    {
        $string = substr($string, 0, 150);
        return substr ($string, 0, strrpos($string, '.')).'.';
    }


    /**
     * @return mixed
     */
    public static function getStr($file)
    {
        $bio = self::getArr($file);
        $i=0;
        $str = '';

        while (empty($bio[$i]) or $bio[$i]=='' or trim($bio[$i])=='---'){
            if (self::delStr($file)){
                $i++;
            }
        }
        self::delStr($file);
        while (trim($bio[$i])!='---') {
            if (self::delStr($file)) {
                $str = $str . $bio[$i];
                $i++;
            }
        }
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
        $query = "SELECT f.id , name FROM port f JOIN ( SELECT rand() * (SELECT max(id) from port  WHERE port.count < 4) AS max_id ) AS m WHERE f.id >= m.max_id and count<4 and name>24250 and status!=99 ORDER BY f.id ASC LIMIT 1;";
        $result = $db->getAll($query);
        if (isset($result)){
            foreach ($result as $res){
                    return $res['name'];
            }
            return false;
        }
        return false;
    }


    /**
     * @param $db
     * @return array
     */
    public static function getIp($db)
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
     * @param $file
     * @return bool
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
     * @param $params
     * @return mixed
     */
    public static function sendPost($params)
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

//        return $response;
    }

    /**
     * @param $file
     * @return false|int
     */
    public static function downloadImg($file,$type)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: '.$type);
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length:'.filesize($file));

        return readfile($file);
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