<?php

namespace Acme\Task\Controller;

use \PHPUnit_Framework_TestCase;
use GuzzleHttp\Client;

class TagControllerTest extends PHPUnit_Framework_TestCase
{
    protected $httpClient;

    protected function setUp()
    {
        $this->httpClient = new Client([
            'base_uri' => 'http://127.0.0.1',
            'http_errors' => false,
        ]);
    }

    public function testMustRespondWithErrorWhenAddingATagWithShortName()
    {
        $response = $this->httpClient->post('/tag/add', [
            'json' => [
                'name' => 'A'
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('message', $data);
    }

    public function testMustRespondWithErrorWhenAddingATagWithEmptyName()
    {
        $response = $this->httpClient->post('/tag/add', [
            'json' => [
                'name' => ''
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('message', $data);
    }


    public function testMustAddTagWithSuccess()
    {
        $name = 'The name - ' . date('U');
        $response = $this->httpClient->post('/tag/add', [
            'json' => [
                'name' => $name
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertEquals($name, $data['name']);
    }

    public function testMustAddTagAndSetColorWithSuccess()
    {
        $colors = ['red', 'blue', 'gray', 'yellow', 'black', 'white'];
        $name = 'The name - ' . date('U');
        $color = $colors[rand(0,5)];
        $response = $this->httpClient->post('/tag/add', [
            'json' => [
                'name' => $name,
                'color' => $color
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertEquals($name, $data['name']);
    }

    public function testMustEditColorWithSuccessAfterCreate()
    {
        $colors = ['red', 'blue', 'gray', 'yellow', 'black', 'white'];
        $color = $colors[rand(0,5)];
        $response = $this->httpClient->post('/tag/edit', [
            'json' => [
                'id' => 1,
                'color' => $color
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertEquals(1, $data['id']);
    }


    public function testMustGetSuccess()
    {
        $response = $this->httpClient->post('/tag/get', [
            'json' => [
                'id' => 1,
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertEquals(1, $data['id']);
    }
}
