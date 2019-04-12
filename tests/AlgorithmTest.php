<?php

use PHPUnit\Framework\TestCase;

require __DIR__.'/../vendor/autoload.php';


class AlgorithmTest extends TestCase
{
    private $http;
    private $login;
    private $token;

    public function setUp()
    {
        $this->login = 'admin';
        $this->token = 'li2j3fojewf';
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://api:8080/']);
//        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://api:8080/?action=showpic&login=admin&token=li2j3fojewf']);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testGetuniqzero()
    {
        $trueResponse = $this->http->request('GET', '?action=getuniqzero&login='.$this->login.'&token=li2j3fojewf');
        $this->assertEquals(200, $trueResponse->getStatusCode());
    }

    public function testGetuniq()
    {
        $trueResponse = $this->http->request('GET', '?action=getuniq&token='.$this->token);
        $this->assertEquals(200, $trueResponse->getStatusCode());
    }

    public function testGetPort()
    {
        $response = $this->http->request('GET', '?action=ip&token='.$this->token);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->expectOutputString('Выдан порт - '.$data);
    }

//    public function testAddUser()
//    {
//        $response = $this->client->get('/', [
//            'query' => [
//                'action' => 'add',
//                'token' => 'li2j3fojewf',
//                'login' => 'logijssjjjn',
//                'password' => 'lo2345gisssaanuser',
//                'ip' => 24501,
//                'age' => 'loginuser',
//                'sex' => 'loginuser',
//                'fullname' => 'loginuser',
//                'phone' => 'loginuser',
//                'country' => 'loginuser',
//            ]
//        ]);
//        $response = $this->http->request('GET', '?action=ip&token='.$this->token);
//        $this->expectOutputString($response->getStatusCode());
//        $this->assertEquals(200, $response->getStatusCode());
//        $data = json_decode($response->getBody(), true);
//        $this->assertContains('200', $data);
//    }
}
