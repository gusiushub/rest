<?php

namespace test;

require_once __DIR__."/../vendor/autoload.php";

use app\api\UserApi;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use app\models\Helper;
use app\db\SafeMySQL;

class UserApiTest extends TestCase
{
    protected $client;


    protected function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://api'
        ]);
    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testAlwaysTrue()
    {
        $this->assertTrue(true);
    }

    /**
     *
     */
    public function testGetPort()
    {
        $response = $this->client->get('/', [
            'query' => [
                'action' => 'ip',
                'token' => 'li2j3fojewf'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->expectOutputString('Выдан порт - '.$data);
    }

//    public function testFunctionCount()
//    {
//        // Протестируем работу стандартной функции count
//        $array3 = array(1, 2, 3);
//        $array0 = array();
//        $array1 = array(1);
//
//        // count($array3) должно вернуть 3
//        $this->assertEquals(3, count($array3));
//        $this->assertEquals(0, count($array0));
//        $this->assertEquals(1, count($array1));
//    }

    public function additionProvider()
    {
        $userApi = new UserApi();
        return $userApi->csvAction();
    }

    public function testAddUser()
    {
        $response = $this->client->get('/', [
            'query' => [
                'action' => 'add',
                'token' => 'li2j3fojewf',
                'login' => 'logijssjjjn',
                'password' => 'lo2345gisssaanuser',
                'ip' => 24501,
                'age' => 'loginuser',
                'sex' => 'loginuser',
                'fullname' => 'loginuser',
                'phone' => 'loginuser',
                'country' => 'loginuser',
            ]
        ]);
        $this->expectOutputString($response->getStatusCode());
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertContains('200', $data);
    }

    public function testShowpic()
    {
        $response = $this->client->get('/', [
            'query' => [
                'action' => 'showpic',
                'token' => 'li2j3fojewf',
                'login' => 'logijssjjjn',
            ]
        ]);

        $response->getStatusCode();
        $data = json_decode($response->getBody(), true);
        $this->expectOutputString($response->getStatusCode());
    }




}