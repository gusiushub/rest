<?php


namespace app\api;

use app\api\Api;
use app\models\Helper;


class UserApi extends Api
{
    private function getImg($img)
    {
        $type = 'image/jpeg';
        header('Content-Type:'.$type);
        header('Content-Length: ' . filesize(__DIR__.'/../img/'.$img));

        return   readfile(__DIR__.'/../img/'.$img);
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
     * @return false|int|string
     */
    public function addAction()
    {
        $get = $this->requestParams;

        if( isset( $get['login'])&& isset( $get['password'])&&
            isset( $get['phone'])&& isset( $get['ip'])&&
            isset( $get['country'])&& isset( $get['sex'])&&
            isset( $get['fullname'])&& isset( $get['age'])) {

                if ($this->isLoginUniq()) {
                    $lastUser = $this->db->getRow("SELECT * FROM users WHERE id=(SELECT MAX(id) FROM users)");
                    $lastPic = Helper::nextLetter($lastUser['Profilepicture']);
                    if ($lastUser['Profilepicture']=="") {
                        $lastPic='a/000/000.jpg';
                    }

                    $user = $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,
                     Sex, Age, Fullname, Date, Bio, Profilepicture) VALUES ('" . $get['login'] . "','" . $get['password'] . "',
                    '" . $get['phone'] . "','" . $get['ip'] . "',
                    '" . $get['country'] . "','" . $get['sex'] . "',
                    '" . $get['age'] . "','" . $get['fullname'] . "',
                    '" . date('Y-m-d H:i:s', time()) . "',
                    '" . Helper::getBio() . "',
                    '" . $lastPic. "')");

                        return $this->getImg($lastPic);
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