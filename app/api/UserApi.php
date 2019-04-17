<?php


namespace app\api;

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

    private function getAuth()
    {
       return array('user' => 'sdd5w%83');
    }
    private function runAuth() {

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo '1400';
            exit;
        } else {
            $user = $_SERVER['PHP_AUTH_USER'];
            $pass = $_SERVER['PHP_AUTH_PW'];
            $auth = $this->getAuth();
            if (!($auth[$user] && $auth[$user] == $pass)) {
                echo '1400';
                exit;
            }
        }
    }
    /**
     * Получения в браузере фоток нужных айдишников по логину
     *
     * @return false|int|string
     */
    public function viewAction()
    {
        $get = $this->requestParams;

        if (isset($get['login'])) {
            $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='" . $get['login'] . "'"));
            if ($user) {
                return $this->response($this->getImg($user['Profilepicture']), 200);
            }

            return $this->response(1460, 1460);
        }

        return $this->response(1400, 1400);
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
     * Отправить аватар
     *
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

                return $this->response(1460, 1460);
            }
        }

        return $this->response(1400, 1400);
    }

    /**
     * получение био
     *
     * @return mixed|string
     */
    public function bioAction()
    {
        $get = $this->requestParams;
        if (isset($get['login'])) {
            $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='" . $get['login'] . "'"));

            if ($user) {
                $str = $user['Bio'];
//                $str = str_replace("\n", " ", $str);
//                return str_replace(chr(10),'',$str);
                return preg_replace("/(\"|\r?\n)/", ' ', $str);
//                ;
//                return $this->response(Helper::cutStr(Helper::delSmile($user['Bio'])), 200);
            }
        }

        return $this->response(1400, 1400);
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
            $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,Sex, Age, Fullname, Date, Bio, Profilepicture, Smsservice, Mother ) VALUES ('" . $get['login'] . "','" . $get['password'] . "'," . (int)$get['phone'] . ",'" . $get['ip'] . "','" . $get['country'] . "'," . (int)$get['sex'] . "," . (int)$get['age'] . ",'" . $get['fullname'] . "','" . date('Y-m-d H:i:s', time()) . "', ?s ,'" . $lastPic . "','" . (int)$sms . "','".(int)$get['mother']."')", Helper::getBio());
        } else {
            $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,Sex, Age, Fullname, Date, Bio, Profilepicture, Smsservice) VALUES ('" . $get['login'] . "','" . $get['password'] . "'," . (int)$get['phone'] . ",'" . $get['ip'] . "','" . $get['country'] . "'," . (int)$get['sex'] . "," . (int)$get['age'] . ",'" . $get['fullname'] . "','" . date('Y-m-d H:i:s', time()) . "', ?s ,'" . $lastPic . "','" . (int)$sms . "')", Helper::getBio());
        }

        Helper::downloadImg(__DIR__.'/../../incoming/'.$lastPic,'image/jpeg');
        $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'"));
        if ($user) {
            $this->db->query("UPDATE port SET last_update=FROM_UNIXTIME(".time().") WHERE name=". (int)$get['ip'].";");
            // $this->sendAvatar($lastPic,$user['id']);

            return $this->response(1200, 1200);
        }
    }

    /**
     * Увеличение postcount на единицу
     *
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
                $this->db->query("UPDATE users SET Lastpostdate=FROM_UNIXTIME(" . time() . ") WHERE " . $str . ";");
                return $this->response(1200, 1200);
            }

            return $this->response(1460, 1460);
        }

        return $this->response(1400, 1400);
    }

    /**
     * Получение не забаненых аккаунтов
     *
     * @return string
     */
    public function getuniqAction()
    {
        $time = time() - 24*60*60;
        $time3h = time() - 3*60*60;
        $user = $this->db->getRow('SELECT users.id as userId, Login, Password, ip FROM users
            LEFT JOIN port
            ON users.ip = port.name 
            WHERE IFNULL(UNIX_TIMESTAMP(users.Lastpostdate),0) < ' . $time . ' and users.Status < 50 and users.Used = 0 and (users.is_sf=1013 or users.is_sf=103) and IFNULL(UNIX_TIMESTAMP(port.dateuse),0) < ' . $time3h . ';');
        if ($user) {
            $this->db->query("UPDATE users SET Used = 1, Useddate = FROM_UNIXTIME(".time().") WHERE id = " . (int)$user['userId'] . ";");
            $this->db->query("UPDATE port SET dateuse = FROM_UNIXTIME(".time().") WHERE name = '" . $user['ip'] . "';");
            $result = [
                'id' => $user['userId'],
                'login' => $user['Login'],
                'password' => $user['Password'],
                'port' => $user['ip'],
            ];

            return $this->response($result, 1200);
        }

        return $this->response(1460, 1460);
    }


    /**
     * @return mixed|string
     */
    public function getuniqzeroAction()
    {
        $get = $this->requestParams;

        $day = time()-60*60*24;

        if (isset($get['login']) or isset($get['userid'])) {
            
            if (isset($get['userid'])) {
                if (is_int((int)$get['userid'])) {

                    $user = $this->db->getRow('SELECT * FROM users WHERE id = ' . (int)$get['userid'] . ' AND IFNULL(UNIX_TIMESTAMP(Lastpostdate),0) < '.$day);
                    if ($user) {

                        $this->db->query("UPDATE users SET Used = ?i, Useddate = ?i WHERE id = ?i AND IFNULL(UNIX_TIMESTAMP(Lastpostdate),0) < ".$day.";" , 0, 0,(int)$get['userid'] );

                        return $this->response(1200, 1200);
                    }

                    return $this->response(1460, 1460);
                }

                return $this->response(1400, 1400);
            }

            if (isset($get['login'])) {
                $user = $this->db->getRow("SELECT * FROM users WHERE Login = '".$get['login']."' AND IFNULL(UNIX_TIMESTAMP(Lastpostdate),0) < ".$day." and is_sf=1013 or is_sf=103;");
                if ($user) {
                    $this->db->query("UPDATE users SET Used = 0, Useddate = 0 WHERE Login = '" . $get['login'] . "';");

                    return $this->response(1200, 1200);
                }

                return $this->response(1460, 1460);
            }
        }

        return $this->response(1400, 1400);
    }

    /**
     * Вывод айпишника того кто делает запрос
     *
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

        if (!empty($result)) {
            return $this->response($result, 1200);
        }

        return $this->response(1500, 1500);
    }

    /**
     * Получение не забаненых аккаунтов
     *
     * @return string
     */
    public function getuserAction()
    {
        $user = $this->db->getRow('SELECT * FROM users WHERE Lastpostdate = (SELECT MIN(Lastpostdate) FROM users) and Status < 50');

        if ($user) {
            $result = [
                'id' => $user['id'],
                'login' => $user['Login'],
                'password' => $user['Password'],
                'port' => $user['ip'],
            ];

            return $this->response($result, 1200);
        }

        return $this->response(1460, 1460);
    }

    /**
     * Выдача айди записи из базы по логину юзера
     *
     * @return string
     */
    public function useridbyloginAction()
    {
        $get = $this->requestParams;
        if (isset($get['login'])) {
            $login = $this->db->getRow("SELECT * FROM users WHERE Login='" . $get['login'] . "'");
            if ($login) {
                return $this->response($login['id'], 1200);
            }
        }
        return $this->response(1400, 1400);
    }

    /**
     * Выдача акка с определенным статусом
     *
     * @return string
     */
    public function userbystatusAction()
    {
        $get = $this->requestParams;
        if (isset($get['status'])) {
            $login = $this->db->getOne("SELECT Login FROM users WHERE Status=".(int)$get['status']);
            if ($login) {
                return $this->response($login, 1200);
            }

            return $this->response(1460, 1460);
        }
        return $this->response(1400, 1400);
    }

    /**
     *  Доступ к портам (IP)
     *
     * @return string
     */
    public function ipAction()
    {
        $port = Helper::getPort($this->db);
        if (isset($port)) {
            if ($port != false) {
                $this->plusPort((int)$port);
                return $this->response($port, 1200);
            }
        }
        return $this->response("0000", 1500);
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
     * Создание пользователя
     *
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
                            break;
                        case 1:
                            $lastPic = 'Female/'.str_pad ($lastPic, 4,"0",STR_PAD_LEFT).'.jpg';
                            return $this->insertUser($get,$lastPic);
                             break;
                    }

                    return $this->response(1201, 1201);
                }

                return $this->response(1460, 1460);
            }

        return $this->response(1501, 1501);
    }


    /**
     * изменить статус
     *
     * @return string
     */
    public function statusAction()
    {
        $get = $this->requestParams;

        if (isset($get['newstatus'])) {
            $user = $this->db->getRow("SELECT * FROM users WHERE Login='".$get['login']."'");
            if ($user) {

                $update = $this->db->query("UPDATE users SET Status=".(int)$get['newstatus'].", statuschangedate = FROM_UNIXTIME(".time().") WHERE Login='".$get['login']."'");

                if ($get['newstatus']==99){
                    $user = $this->db->getRow("SELECT * FROM users WHERE Login='".$get['login']."'");
                    if ($user) {
                        $this->db->query("UPDATE port SET status=".(int)$get['newstatus'].", statuschangedate = FROM_UNIXTIME(".time().") WHERE name='".$user['ip']."'");
                    }
                }
                return $this->response(1200, 1200);
            }
            return $this->response(1460, 1460);
        }

        return $this->response(1400, 1400);
    }

    /**
     * Доступ к логам. app/log/log.log - файл для записи логов
     *
     * log
     */
    public function logAction()
    {
        $log = file_get_contents(__DIR__.'/../log/log.log');

        echo $log;
    }

    /**
     * Выгрузка csv
     *
     * @return mixed|void
     */
    public function csvAction()
    {

        $this->runAuth();

        $value = $this->db->getAll("SELECT * FROM users ORDER BY id ASC");
        $fp = fopen('file.csv', 'w');

        foreach ($value as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);
        echo file_get_contents('file.csv');
    }

    /**
     * Статистика по портам
     *
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
            foreach ($usedCount as $key => $val) {
               if ($val['ip'] === $res['name']) {
                   $count = $val['count'];
               }
            }
            echo '
             ' . $res['name'] . ' - ' . $count . ' / ' . $res['count'] . '';
        }
    }
    public function rewriteAction() {
        return Helper::rewrite($this->db);
    }

    /**
     * Таблица с юзерами
     *
     * @return mixed|void
     */
    public function getTableAction()
    {
        header('Content-Type: text/html');

        $this->runAuth();
        
        $get = $this->requestParams;
        if (isset($get['query'])) {
            $query = $get['query'];
        } else {
            $query = "SELECT * FROM `users` order by Date desc limit 50;";
        }

        $all = $this->db->getAll($query);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ids = '';
            foreach ($all as $key => $val) {
               $ids .= $val['id'] . ',';
            }
            $ids = substr($ids, 0, -1);
            $this->db->query("UPDATE users SET Used = 0 WHERE id in ($ids)");
        }
        echo '<style>.row{border-bottom: 1px solid black} table td:not(:last-child), table th:not(:last-child) {border-right: 1px solid black;} table img {width: 50px;}</style><form method="get">
            <input type="hidden" name="action" value="gettable" />
            <input type="hidden" name="token" value="'.$get["token"].'" />
          <input name="query" style="width:calc(100% - 40px)" type="text" value="'.$query.'">
          <button type="submit">Set</button>
         </form>';
        $all = $this->db->getAll($query);

        $time = time() - 24*60*60;
        $time3h = time() - 3*60*60;
        $user = $this->db->getAll('SELECT * FROM users
            LEFT JOIN port
            ON users.ip = port.name 
            WHERE IFNULL(UNIX_TIMESTAMP(users.Lastpostdate),0) < ' . $time . ' and users.Status < 50 and users.Used = 0 and (users.is_sf=1013 or users.is_sf=103) and IFNULL(UNIX_TIMESTAMP(port.dateuse),0) < ' . $time3h . ';');

        echo '<div style="float:left">Get unique user rows: '.sizeof($user).'. </div><form style="float:left; margin-left:20px" method="post">
          <button type="submit">Set USED=0 for all</button>
         </form>';
        echo '<table style="border: 1px solid black; text-align: center; width: 100%; border-collapse: collapse;">
           <tr class="row">
            <th>Аватар</th>
            <th>Логин</th>
            <th>Дата создания</th>
            <th>Пол</th>
            <th>Возраст</th>
            <th>Посткаунт</th>
            <th>Дата последнего поста</th>
            <th>Стата sf</th>
           </tr>';
        foreach ($all as $key => $val) {
            echo '<tr class="row"><td><a href="http://104.248.82.215/filter_images.php?id_profile=' . $val['id'] . '"><img src="/incoming/' . $val['Profilepicture'] . '"></a></td><td>' . $val['Login'] . '</td><td>' . $val['Date'] . '</td><td>' . ($val['Sex'] ? 'female' : 'male') . '</td><td>' . $val['Age'] . '</td><td>' . $val['Postcount'] . '</td><td>' . $val['Lastpostdate'] . '</td><td>' . $val['is_sf'] . '</td>';
            
        }
        echo '</table>

        ';
    }
}