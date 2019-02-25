<?php


namespace app\api;

use app\api\Api;
use app\models\Helper;


class UserApi extends Api
{
    /**
     * @return false|int|string
     */
    public function viewAction()
    {
        $get = $this->requestParams;

        $user = $this->db->fetch($this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'"));

        if ($user) {
            $type = 'image/jpeg';
            header('Content-Type:'.$type);
            header('Content-Length: ' . filesize('img/'.$user['Profilepicture']));
            return   readfile('img/'.$user['Profilepicture']);
        }

        return $this->response('Data not found', 404);
    }


    /**
     * @return false|int|string
     */
    public function addAction()
    {
        $get = $this->requestParams;

        if( isset( $get['login'])&&
            isset( $get['password'])&&
            isset( $get['phone'])&&
            isset( $get['ip'])&&
            isset( $get['country'])&&
            isset( $get['sex'])&&
            isset( $get['fullname'])&&
            isset( $get['age'])) {

                $uniq = $this->db->query("SELECT * FROM users WHERE Login='".$get['login']."'");
                if ($uniq->num_rows === 0) {
                    $lastUser = $this->db->fetch($this->db->query("SELECT * FROM users WHERE id=(SELECT MAX(id) FROM users)"));

                    $lastPic = Helper::nextLetter($lastUser['Profilepicture']);
                    if ($lastUser['Profilepicture']=="") {
                        $lastPic='a/000/000.jpg';
                    }

                    $user = $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,
                     Sex,Age,Fullname,Date,Profilepicture) VALUES (
                    '" . $get['login'] . "',
                    '" . $get['password'] . "',
                    '" . $get['phone'] . "',
                    '" . $get['ip'] . "',
                    '" . $get['country'] . "',
                    '" . $get['sex'] . "',
                    '" . $get['age'] . "',
                    '" . $get['fullname'] . "',
                    '" . date('Y-m-d H:i:s', time()) . "',
                    '" . $lastPic. "')");

                    if ($user) {
                        $type = 'image/jpeg';
                        header('Content-Type:'.$type);
                        header('Content-Length: ' . filesize('img/'.$lastPic));
                        readfile('img/'.$lastPic);
                        return $this->response('Data updated.', 200);
                    }
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

}