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


    public function avatarAction()
    {
        $get = $this->requestParams;

        if (isset($get['status']) && isset($get['login'])){

            if ($get['status']=='ok'){

                $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'"));

                if ($user) {

                    $post = [
                        'id_profile' => $user['id'],
                        'image' => $user['Profilepicture']
                    ];
                    $headers = array();
                    $headers[] = 'Accept-Encoding: gzip, deflate, sdch';
                    $headers[] = 'Accept-Language: ru,en-US;q=0.8,en;q=0.6';
                    $headers[] = 'Upgrade-Insecure-Requests: 1';
                    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.75 Safari/537.36';
                    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8';
                    $headers[] = 'Cache-Control: max-age=0';
                    $headers[] = 'Connection: keep-alive';

                    $params = [
                      'url' => 'http://104.248.82.215/sfparser.php',
                        'headers' => $headers,
                        'postfields' => $post,
//                        'id_profile' => $user['id'],
//                        'image' => $user['Profilepicture']

                    ];
                    return Helper::sendPost($params);
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
                return $this->response($user['Bio'], 200);
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
     */
    private function insertUser($get, $lastPic)
    {
//        var_dump(Helper::getIp($this->db)); exit;
        $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,Sex, Age, Fullname, Date, Bio, Profilepicture) VALUES ('" . $get['login'] . "','" . $get['password'] . "'," . (int)$get['phone'] . ",'" . $get['ip'] . "','" . $get['country'] . "'," . (int)$get['sex'] . "," . (int)$get['age'] . ",'" . $get['fullname'] . "','" . date('Y-m-d H:i:s', time()) . "','" . Helper::getBio() . "','" . $lastPic. "')");
    }

    /**
     * @return string
     */
    public function ipAction()
    {
        $ip = Helper::getPort($this->db);
        if (isset($ip)){
            $this->db->query("INSERT INTO ip ( ip ) values ('".$ip."')");
            return $this->response($ip, 200);
        }
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
                            return Helper::downloadImg($lastPic);
                            break;
                        case 1:
                             $lastPic = 'Female/'.str_pad ($lastPic, 4,"0",STR_PAD_LEFT).'.jpg';
                            $this->insertUser($get,$lastPic);
                            Helper::downloadImg(__DIR__.'/../../incoming/'.$lastPic,'image/jpeg');
                            return $this->response("200", 200);
                             break;
                    }
                    return $this->response("200", 200);
//                    return $this->getImg($lastPic);
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

}