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
//        $falseResponse = $this->http->request('GET', '?action=getuniqzero&token=li2j3fojewf');
        $this->assertEquals(200, $trueResponse->getStatusCode());
//        $this->assertEquals('404 Not Found', $falseResponse->getStatusCode());

    }

    public function testGetuniq()
    {
        $trueResponse = $this->http->request('GET', '?action=getuniq&token='.$this->token);
//        $falseResponse = $this->http->request('GET', '?action=getuniq&token=li2j3fojewf');
        $this->assertEquals(200, $trueResponse->getStatusCode());
//        $this->assertEquals(404, $falseResponse->getStatusCode());

    }
}
