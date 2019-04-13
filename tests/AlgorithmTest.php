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
        $this->login = 'mouamargaret';
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
        $this->expectOutputString('Статус у action=getuniqzero => '.$trueResponse->getStatusCode());
    }

    public function testGetuniq()
    {
        $trueResponse = $this->http->request('GET', '?action=getuniq&token='.$this->token);
        $this->assertEquals(200, $trueResponse->getStatusCode());
        $this->expectOutputString('Статус у action=getuniq => '.$trueResponse->getStatusCode());
    }

    public function testGetPort()
    {
        $response = $this->http->request('GET', '?action=ip&token='.$this->token);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->expectOutputString('Выдан порт - '.$data.' | Статус у action=ip => '.$response->getStatusCode());
//        $this->expectOutputString('Статус у action=ip => '.$response->getStatusCode());
    }

    public function testShowpic()
    {
        $response = $this->http->request('GET', '?action=showpic&login='.$this->login.'&token='.$this->token);
        $this->assertEquals(200, $response->getStatusCode());
        $this->expectOutputString('Статус у action=getuniq => '.$response->getStatusCode());
    }

    public function testAddUser()
    {

    }

    public function testCsv()
    {

    }

    public function testDashboard()
    {

    }

    public function testGetIp()
    {
        $response = $this->http->request('GET', '?action=getip&token='.$this->token);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->expectOutputString('IP ------> '.$data['ip'].' | Статус у action=getip => '.$response->getStatusCode());
    }
}
