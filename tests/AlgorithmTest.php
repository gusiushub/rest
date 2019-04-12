<?php

use PHPUnit\Framework\TestCase;

require __DIR__.'/../vendor/autoload.php';
class AlgorithmTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://api:8080/?action=showpic&login=admin&token=li2j3fojewf']);
    }

    public function tearDown() {
        $this->http = null;
    }

    public function testGet()
    {
        $response = $this->http->request('GET');
        $this->assertEquals(200, $response->getStatusCode());
        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);
        $userAgent = json_decode($response->getBody())->{"user-agent"};
        $this->assertRegexp('/Guzzle/', $userAgent);
    }
}
