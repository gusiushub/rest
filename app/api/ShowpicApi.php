<?php
/**
 * Created by PhpStorm.
 * User: zolow
 * Date: 21.02.2019
 * Time: 23:48
 */

namespace app\api;
require_once 'Api.php';


class ShowpicApi extends Api
{
    /**
     * Метод GET
     * Просмотр отдельной записи (по id)
     * http://ДОМЕН/users/1
     * @return string
     */
    public function viewAction()
    {

        //id должен быть первым параметром после /users/x
        $id = array_shift($this->requestUri);
//        echo $id;
//        exit;
//        var_dump($id);exit;
        if($id){

//            $db = (new Db())->getConnect();
//            $db = new Db();
            $opts = array(
                'user'    => 'root',
                'pass'    => '',
                'db'      => 'rest',
                'charset' => 'utf8'

            );
            $db= new SafeMySQL($opts);

            $user = $db->getOne("SELECT * FROM users WHERE id=?i", $id);
            var_dump($user);
//            $user = $db->getById($id);
            if($user){
                return $this->response($user, 200);
            }
        }
        return $this->response('Data not found', 404);
    }
}