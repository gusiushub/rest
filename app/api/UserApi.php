<?php


namespace app\api;

use app\api\Api;
use app\models\Helper;


class UserApi extends Api
{
    /**
     * @param $img
     * @return false|int
     */
    private function getImg($img)
    {
        $type = 'image/jpeg';
        header('Content-Type:'.$type);
        header('Content-Length: ' . filesize(__DIR__.'/../../incoming/'.$img));

        return   readfile(__DIR__.'/../../incoming/'.$img);
    }


    /**
     * @return false|int|string
     */
    public function viewAction()
    {
        $get = $this->requestParams;

        $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'"));

        if ($user) {
            return $this->getImg($user['Profilepicture']);
        }

        return $this->response('Data not found', 404);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function sendRequestInService($params)
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

        return $response;
    }

    /**
     * @param $file
     * @param $userId
     */
    private function sendAvatar($file, $userId)
    {
        $postfields = array();
        // тут путь к картинке, которая будет отправляться
        $file = __DIR__ . '/../../incoming/' . $file;
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // возвращает mime-тип
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);
        $curlFile = curl_file_create($file, $mime, basename($file));
        $postfields['image'] = $curlFile;
        $postfields['id_profile'] = $userId;
        $url = 'http://104.248.82.215/sfparser.php';
        $headers = array("Content-Type" => "multipart/form-data");
        $this->db->query("UPDATE users SET is_sf='".$this->sendRequestInService(array('url' => $url, 'headers' => $headers, 'postfields' => $postfields))."' WHERE id=" . $userId . ";");

    }

    /**
     * @return mixed|string
     */
    public function avatarAction()
    {
        $get = $this->requestParams;

        if (isset($get['status']) && isset($get['login'])){

            if ($get['status']=='ok'){

                $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'"));
                if ($user) {

                    $postfields = array();

                    // тут путь к картинке, которая будет отправляться
                    $file = __DIR__.'/../../incoming/'.$user['Profilepicture'];

                    $finfo = finfo_open(FILEINFO_MIME_TYPE); // возвращает mime-тип
                    $mime = finfo_file($finfo, $file);
                    finfo_close($finfo);

                    $curlFile = curl_file_create($file, $mime, basename($file));
                    $postfields['image'] = $curlFile;

                    // id_profile
                    $postfields['id_profile'] = $user['id'];

                    $url = 'http://104.248.82.215/sfparser.php';

                    $headers = array("Content-Type" => "multipart/form-data");
                    $resultSearching = $this->sendRequestInService(array('url' => $url, 'headers' => $headers, 'postfields' => $postfields));
                    echo $resultSearching;
                    die;
                }

                return $this->response('Not found', 404);
            }
        }
    }



    /**
     * @return mixed|string
     */
    public function bioAction()
    {
        $get = $this->requestParams;
        if (isset($get['login'])) {
            $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='" . $get['login'] . "'"));

            if ($user) {
                return $this->response(Helper::cutStr(Helper::delSmile($user['Bio'])), 200);
            }
        }

        return $this->response('Data not found', 404);
    }

    /**
     * @return bool
     */
    private function isLoginUniq()
    {
        $get = $this->requestParams;
        $login =$this->db->getRow("SELECT * FROM users WHERE Login='".$get['login']."'");
        if ($login==null) {
            return true;
        }
        return false;
    }

    /**
     * @param $get
     * @param $lastPic
     * @return string
     */
    private function insertUser($get, $lastPic)
    {
        $sms = isset($get['smsservice']) ? (int)$get['smsservice'] : 0;

        if (isset($get['mother'])){
            $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,Sex, Age, Fullname, Date, Bio, Profilepicture, Smsservice, Mother ) VALUES ('" . $get['login'] . "','" . $get['password'] . "'," . (int)$get['phone'] . ",'" . $get['ip'] . "','" . $get['country'] . "'," . (int)$get['sex'] . "," . (int)$get['age'] . ",'" . $get['fullname'] . "','" . date('Y-m-d H:i:s', time()) . "','" . Helper::getBio() . "','" . $lastPic . "','" . (int)$sms . "','".(int)$get['mother']."')");
        } else {
            $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,Sex, Age, Fullname, Date, Bio, Profilepicture, Smsservice) VALUES ('" . $get['login'] . "','" . $get['password'] . "'," . (int)$get['phone'] . ",'" . $get['ip'] . "','" . $get['country'] . "'," . (int)$get['sex'] . "," . (int)$get['age'] . ",'" . $get['fullname'] . "','" . date('Y-m-d H:i:s', time()) . "','" . Helper::getBio() . "','" . $lastPic . "','" . (int)$sms . "')");
        }

        Helper::downloadImg(__DIR__.'/../../incoming/'.$lastPic,'image/jpeg');
        $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'"));
        if ($user) {
            $this->db->query("UPDATE port SET last_update=".time()." WHERE name=". (int)$get['ip'].";");
            $this->sendAvatar($lastPic,$user['id']);

            return $this->response("200", 200);
        }
    }

    /**
     * @return string
     */
    public function postcountAction()
    {
        $get = $this->requestParams;
        $userId = $get['userid'];

        if (isset($get['login']) || isset($userId)) {
            if ($userId) {
                $str = "Id='" . $userId . "'";
            } else {
                $str = "Login='" . $get['login'] . "'";
            }
            $login = $this->db->getRow("SELECT * FROM users WHERE " . $str);

            if ($login) {
                $this->db->query("UPDATE users SET Postcount=Postcount+1 WHERE " . $str . ";");
                $this->db->query("UPDATE users SET Lastpostdate=" . time() . " WHERE " . $str . ";");
                return $this->response("200", 200);
            }
        }
        return $this->response("error", 500);
    }

    /**
     * @return string
     */
    public function getuniqAction()
    {
        $time = time() - 24*60*60;

        $user = $this->db->getRow('SELECT * FROM users WHERE Lastpostdate < ' . $time . ' and Status < 50 and Used = 0');

        $this->db->query("UPDATE users SET Used = 1 WHERE id = " . $user['id'] . ";");

        $result = [
            'id' => $user['id'],
            'login' => $user['Login'],
            'password' => $user['Password'],
            'port' => $user['ip'],
        ];

        return $this->response($result, 200);

    }

    /**
     * @return string
     */
    public function getuniqzeroAction()
    {

        $time = time() - 24*60*60;

        $user = $this->db->getRow('SELECT * FROM users WHERE Lastpostdate < ' . $time . ' and Status < 50 and Used = 1');

        $this->db->query("UPDATE users SET Used = 0 WHERE id = " . $user['id'] . ";");

        $result = [
            'id' => $user['id'],
            'login' => $user['Login'],
            'password' => $user['Password'],
            'port' => $user['ip'],
        ];

        return $this->response($result, 200);

    }

    /**
     * @return string
     */
    public function getIpAction()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        
        $result = [
            'ip' => $ipaddress
        ];

        return $this->response($result, 200);

    }
    /**
     * @return string
     */
    public function getuserAction()
    {
        $user = $this->db->getRow('SELECT * FROM users WHERE Lastpostdate = (SELECT MIN(Lastpostdate) FROM users) and Status < 50');

        $result = [
            'id' => $user['id'],
            'login' => $user['Login'],
            'password' => $user['Password'],
            'port' => $user['ip'],
        ];

        return $this->response($result, 200);
    }


    /**
     * @return string
     */
    public function useridbyloginAction()
    {
        $get = $this->requestParams;
        if (isset($get['login'])) {
            $login = $this->db->getRow("SELECT * FROM users WHERE Login='" . $get['login'] . "'");
            if ($login) {
                return $this->response($login['id'], 200);
            }
        }
        return $this->response("error", 500);
    }

    /**
     * @return string
     */
    public function userbystatusAction()
    {
        $get = $this->requestParams;
        if (isset($get['status'])) {
            $login = $this->db->getOne("SELECT Login FROM users WHERE Status=".(int)$get['status']);
            if ($login) {
                return $this->response($login, 200);
            }
        }
        return $this->response("error", 500);
    }

    /**
     * @return string
     */
    public function ipAction()
    {
        $port = Helper::getPort($this->db);
        if (isset($port)) {
            if ($port != false) {
                $this->plusPort((int)$port);
                return $this->response($port, 200);
            }
        }
        return $this->response("0000", 500);
    }

    /**
     *
     * @param $port
     * @return FALSE|resource
     */
    private function plusPort($port)
    {
        return $this->db->query("UPDATE port SET count=count+1 WHERE name=" . (int)$port . ";");

    }


    /**
     * @return false|int|string
     */
    public function addAction()
    {
        $get = $this->requestParams;

        if( isset( $get['login'])&& isset( $get['password'])&&
            isset( $get['phone'])&&isset( $get['country'])&&
            isset( $get['sex'])&& isset( $get['fullname'])&& isset( $get['age'])) {

                if ($this->isLoginUniq()) {
                    $lastUser = $this->db->getRow("SELECT * FROM users WHERE Sex=".$get['sex']." ORDER BY id DESC");
                    $name = explode('/',$lastUser['Profilepicture']);
                    $lastPic = $name[1]+1;
                    switch ($get['sex']){
                        case 0:
                             $lastPic = 'Male/'.str_pad ($lastPic, 4,"0",STR_PAD_LEFT).'.jpg';
                            $this->insertUser($get,$lastPic);
//                            Helper::downloadImg(__DIR__.'/../../incoming/'.$lastPic,'image/jpeg');
//                            $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'"));
//                            if ($user) {
//                                $this->sendAvatar($lastPic,$user['id']);
//
//                                return $this->response("200", 200);
//                            }
                            break;
                        case 1:
                            $lastPic = 'Female/'.str_pad ($lastPic, 4,"0",STR_PAD_LEFT).'.jpg';
                            return $this->insertUser($get,$lastPic);
                             break;
                    }

                    return $this->response("200", 200);
                }
                return $this->response("login exists", 500);
        }
        return $this->response("Saving error", 500);
    }


    /**
     * @return string
     */
    public function statusAction()
    {
        $get = $this->requestParams;

        if (isset($get['newstatus'])) {
            $update = $this->db->query("UPDATE users SET Status=".(int)$get['newstatus']." WHERE Login='".$get['login']."'");
            if ($update) {
                if ($get['newstatus']==99){
                    $user = $this->db->getRow("SELECT * FROM users WHERE Login='".$get['login']."'");
                    $this->db->query("UPDATE port SET status=".(int)$get['newstatus']." WHERE name='".$user['ip']."'");
                }
                return $this->response('Status updated.', 200);
            }
        }

        return $this->response("Update error", 400);
    }

    /**
     * log
     */
    public function logAction()
    {
        $log = file_get_contents(__DIR__.'/../log/log.log');

        echo $log;
    }

    /**
     * @return mixed|void
     */
    public function csvAction()
    {
        $value = $this->db->getAll("SELECT * FROM users ORDER BY id ASC");
        $fp = fopen('file.csv', 'w');

        foreach ($value as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        echo file_get_contents('file.csv');
    }

    /**
     * @return mixed|void
     */
    public function dashboardAction()
    {
        $query = "SELECT * FROM port ORDER BY count DESC;";
        $usedCount = $this->db->getAll("SELECT ip, count(*) as count FROM users GROUP BY ip;");

        $sum = $this->db->getRow("SELECT SUM(count) as sum FROM port;");

        $result = $this->db->getAll($query);
        $count = count($result)*4;

        echo '
        Всего '.$count.'
        ';
        $ost = $count-$sum['sum'];
        echo 'Осталось '. $ost.'
        ';
        echo '--ниже список проксей и количество успешных / количество попыток их использований по базе--';
        foreach ($result as $res) {
            $count = 0;
            foreach ($usedCount as $key => $val) {;
               if ($val['ip'] === $res['name']) {
                   $count = $val['count'];
               }
           }
            echo '
             ' . $res['name'] . ' - ' . $count . ' / ' . $res['count'] . '';
        }

    }

}