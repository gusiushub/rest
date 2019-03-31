<?php

namespace test;

require_once __DIR__."/../vendor/autoload.php";

use PHPUnit_Framework_TestCase;
use GuzzleHttp\Client;



class UserApiTest extends PHPUnit_Framework_TestCase
{
    protected $client;


    protected function setUp()
    {
        $this->client = new Client([
            'base_uri' => 'http://api'
        ]);
    }

    public function testAlwaysTrue()
    {
        $this->assertTrue(true);
    }

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

//        $response2 = $this->client->request('GET', 'user-agent', ['http_errors' => false]);

//        $this->assertEquals(500, $response2->getStatusCode());
//
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertContains('200', $data);
//        $this->assertEquals(500, $response->getStatusCode());
//        $this->assertEquals('login exists', $response->getStatusCode());
//        $data = json_decode($response->getBody(), true);
    }

    public function testShowpic()
    {
        $response = $this->client->get('/', [
            'query' => [
                'action' => 'showpic',
                'token' => 'li2j3fojewf',
                'login' => 'loginusssser',
            ]
        ]);


        $data = json_decode($response->getBody(), true);
        echo $response->getStatusCode();
        return $response->getStatusCode();
//        $this->assertEquals($data, $response->getStatusCode());
    }

    public function tearDown()
    {
        $this->client = null;
    }
}