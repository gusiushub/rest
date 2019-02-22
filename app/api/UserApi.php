<?php


namespace app\api;

use app\db\Db;
use app\db\SafeMySQL;
use app\models\Users;
//use app\db\SafeMySQL;

//use app\api\Api;
//use app\a\Users;

require_once 'Api.php';
//require_once 'Db.php';
//require_once 'models/Users.php';
require_once 'db/SafeMySQL.php';

class UserApi extends Api
{
//    public $apiName='users';

//    public function __construct()
//    {
//        var_dump(explode('/',$this->requestUri[0][0])[1]);
//        $this->apiName='users';
//    }

    /**
     * Метод GET
     * Вывод списка всех записей
     * http://ДОМЕН/users
     * @return string
     */
    public function indexAction()
    {
//        $db = (new Db())->getConnect();
//        $db = new Users();
//        $users = $db->getAll();
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

    /**
     * Метод POST
     * Создание новой записи
     * http://ДОМЕН/users + параметры запроса name, email
     * @return string
     */
    public function createAction()
    {
        $val = $this->requestUri;
        $get = $this->requestParams;
        if(isset($get['token']) && isset( $get['id'])) {
            $opts = array(
                'user' => 'root',
                'pass' => '',
                'db' => 'tttt',
                'charset' => 'utf8'

            );
            $db = new SafeMySQL($opts);
            $user = $db->fetch($db->query("SELECT * FROM qqqq WHERE id='" . (int)$get['id'] . "'"));
//            var_dump($user);
//            if ($user['name'] === $get['token']) {
                $uniq = $db->query("SELECT * FROM qqqq WHERE id=" .(int)$get['id']);
//                $uniq = $db->query("SELECT * FROM qqqq WHERE name='" . $val[1][0] . "'");
                if ($uniq->num_rows === 0) {
                    $user = $db->query("INSERT INTO qqqq (name, email) VALUES ('" . $val[1][0] . "','asdasdasd')");
//
                    if ($user) {
                        return $this->response('Data saved.', 200);
                    }
                }
//            }
        }
        return $this->response("Saving error", 500);
    }

    /**
     * Метод PUT
     * Обновление отдельной записи (по ее id)
     * http://ДОМЕН/users/1 + параметры запроса name, email
     * @return string
     */
    public function updateAction()
    {
        $parse_url = parse_url($this->requestUri[0]);
        $userId = $parse_url['path'] ?? null;

        $db = (new Db())->getConnect();

        if(!$userId || !Users::getById($db, $userId)){
            return $this->response("User with id=$userId not found", 404);
        }

        $name = $this->requestParams['name'] ?? '';
        $email = $this->requestParams['email'] ?? '';

        if($name && $email){
            if($user = Users::update($db, $userId, $name, $email)){
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