<?php


namespace app\api;

use app\api\Api;
use app\models\Helper;


class UserApi extends Api
{
    private function getImg($img)
    {
//        echo '<img src="'.__DIR__.'/../../'.$img.'">';
//        var_dump($img); exit;
        $type = 'image/jpeg';
        header('Content-Type:'.$type);
        header('Content-Length: ' . filesize(__DIR__.'/../../incoming/'.$img));
//        header('Content-Length: ' . filesize(__DIR__.'/../../'.$img));

        return   readfile(__DIR__.'/../../incoming/'.$img);
//        return   readfile(__DIR__.'/../../'.$img);
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
                    $lastUser = $this->db->getRow("SELECT * FROM users WHERE Sex=".$get['sex']." ORDER BY id DESC");
                    $name = explode('/',$lastUser['Profilepicture']);

                    $lastPic = $name[2]+1;
//
                    switch ($get['sex']){
                        case 0:
                             $lastPic = 'Male/'.str_pad ($lastPic, 4,"0",STR_PAD_LEFT).'.jpg';
                            $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,
                     Sex, Age, Fullname, Date, Bio, Profilepicture) VALUES ('" . $get['login'] . "','" . $get['password'] . "',
                    '" . $get['phone'] . "','" . $get['ip'] . "',
                    '" . $get['country'] . "','" . $get['sex'] . "',
                    '" . $get['age'] . "','" . $get['fullname'] . "',
                    '" . date('Y-m-d H:i:s', time()) . "',
                    '" . Helper::getBio() . "',
                    '" . $lastPic. "')");
                            return $this->getImg($lastPic);
//                            return $this->getImg($lastPic.".jpg");
                            break;

                        case 1:
                             $lastPic = 'Female/'.str_pad ($lastPic, 4,"0",STR_PAD_LEFT).'.jpg';
                            $this->db->query("INSERT INTO users ( Login,  Password,  Phone,  ip,  Country,
                     Sex, Age, Fullname, Date, Bio, Profilepicture) VALUES ('" . $get['login'] . "','" . $get['password'] . "',
                    '" . $get['phone'] . "','" . $get['ip'] . "',
                    '" . $get['country'] . "','" . $get['sex'] . "',
                    '" . $get['age'] . "','" . $get['fullname'] . "',
                    '" . date('Y-m-d H:i:s', time()) . "',
                    '" . Helper::getBio() . "',
                    '" . $lastPic. "')");
                            return $this->getImg($lastPic);
//                            return $this->getImg($lastPic.'.jpg');
                             break;
                    }
//                    var_dump($lastPic); exit;
//                    $lastPic = Helper::nextLetter($lastUser['Profilepicture']);
//                    if ($lastUser['Profilepicture']=="") {
//                        $lastPic='a/000/000.jpg';
//                    }

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