<?php


namespace app\api;

use app\db\Db;
use app\db\SafeMySQL;
use app\models\Users;


require_once 'Api.php';
require_once 'db/SafeMySQL.php';

class UserApi extends Api
{
//    public $apiName='users';

    /**
     * @return string
     */
    public function indexAction()
    {
        $opts = array(
            'user'    => 'root',
            'pass'    => '',
            'db'      => 'rest',
            'charset' => 'utf8'

        );
        $db= new SafeMySQL($opts);
        $users = $db->getAll("SELECT * FROM users");
        if($users){
            return $this->response($users, 200);
        }
        return $this->response('Data not found', 404);
    }

    /**
     * @param $fileName
     * @return string
     */
    public function nextLetter($fileName)
    {
        $array = $this->getL();
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
                return $fileName[0].'/00'.$fileName[1].'/'.$fileName[2].'.jpg';
            }
            if (iconv_strlen($fileName[1])==2){
                return $fileName[0].'/0'.$fileName[1].'/'.$fileName[2].'.jpg';
            }
            return $fileName[0].'/'.$fileName[1].'/'.$fileName[2].'.jpg';
        }elseif($fileName[1]>998 && $fileName[2]>997){

            $numLetter = $this->getLetter($this->getLastLetter($fileName[0]));
            $arr = $this->getName($fileName[0]);
            $count = count($arr);
            if ($numLetter!=26){
                $arr[$count-1]=$array[$numLetter+1];

                return implode($arr).'/000/000.jpg';
            }else{
                $arrLet = array();
                for ($i=0;$i<$count+1;$i++){
                    $arrLet[$i]='a';
                }
                return implode($arrLet).'/000/000.jpg';
            }
        }
    }

    /**
     * @param $filename
     * @return array
     */
    public  function getName($filename)
    {
        return str_split($filename);
    }

    /**
     * @param $filename
     * @return mixed
     */
    public function getLastLetter($filename)
    {
        $arr = $this->getName($filename);
        $count = count($arr);
        return $arr[$count-1];
    }

    /**
     * @return array
     */
    public function getL()
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
    public function getLetter($name)
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


    /**
     * @return false|int|string
     */
    public function viewAction()
    {
            $get = $this->requestParams;
            $opts = array(
                'user'    => 'root',
                'pass'    => '',
                'db'      => 'rest',
                'charset' => 'utf8'

            );
            $db= new SafeMySQL($opts);
            $user = $db->query("SELECT * FROM users WHERE Login='".$get['login']."'");
            $user = $db->fetch($user);
        if ($user) {
            $type = 'image/jpeg';
            header('Content-Type:'.$type);
            header('Content-Length: ' . filesize('img/'.$user['Profilepicture']));
            return   readfile('img/'.$user['Profilepicture']);
        }

        return $this->response('Data not found', 404);
    }


    public function createAction()
    {
        $val = $this->requestUri;
        $get = $this->requestParams;
        if(isset($get['token']) &&
            isset( $get['login'])&&
            isset( $get['password'])&&
            isset( $get['phone'])&&
            isset( $get['ip'])&&
            isset( $get['country'])&&
            isset( $get['sex'])&&
            isset( $get['fullname'])&&
            isset( $get['age'])) {
            $opts = array(
                'user' => 'root',
                'pass' => '',
                'db' => 'rest',
                'charset' => 'utf8'

            );
            $db = new SafeMySQL($opts);
                $uniq = $db->query("SELECT * FROM users WHERE Login='".$get['login']."'");
                if ($uniq->num_rows === 0) {
                    $lastUser = $db->fetch($db->query("SELECT * FROM users WHERE id=(SELECT MAX(id) FROM users)"));

                    $lastPic = $this->nextLetter($lastUser['Profilepicture']);
                    if ($lastUser['Profilepicture']=="") {
                        $lastPic='a/000/000.jpg';
                    }
                        $user = $db->query("INSERT INTO users (Login, Password,Phone,ip,Country,Sex,Age,Fullname,Profilepicture) VALUES (
                    '" . $get['login'] . "',
                    '" . $get['password'] . "',
                    '" . $get['phone'] . "',
                    '" . $get['ip'] . "',
                    '" . $get['country'] . "',
                    '" . $get['sex'] . "',
                    '" . $get['age'] . "',
                    '" . $get['fullname'] . "',
                    '" . $lastPic. "')");
                    if ($user) {
                        $type = 'image/jpeg';
                        header('Content-Type:'.$type);
                        header('Content-Length: ' . filesize('img/'.$lastPic));
                        return  readfile('img/'.$lastPic);
                    }
                }
            return $this->response("login exists", 500);
        }
        return $this->response("Saving error", 500);
    }


    /**
     * @return string
     */
    public function updateAction()
    {
        $get = $this->requestParams;
        $opts = array(
            'user' => 'root',
            'pass' => '',
            'db' => 'rest',
            'charset' => 'utf8'

        );
        $db = new SafeMySQL($opts);

    if (isset($get['newstatus'])) {
        $update = $db->query("UPDATE users SET Status=".(int)$get['newstatus']." WHERE Login='".$get['login']."'");
        if ($update) {
            return $this->response('Data updated.', 200);
        }
    }
        return $this->response("Update error", 400);
    }

    /**
     * Метод DELETE
     * Удаление отдельной записи (по ее id)
     * http://ДОМЕН/users/1
     * @return string
     */
    public function deleteAction()
    {
        $parse_url = parse_url($this->requestUri[0]);
        $userId = $parse_url['path'] ?? null;

        $db = (new Db())->getConnect();

        if(!$userId || !Users::getById($db, $userId)){
            return $this->response("User with id=$userId not found", 404);
        }
        if(Users::deleteById($db, $userId)){
            return $this->response('Data deleted.', 200);
        }
        return $this->response("Delete error", 500);
    }

}