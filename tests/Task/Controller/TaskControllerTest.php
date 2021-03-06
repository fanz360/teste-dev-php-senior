<?php

namespace Acme\Task\Controller;

use \PHPUnit_Framework_TestCase;
use GuzzleHttp\Client;

class TaskControllerTest extends PHPUnit_Framework_TestCase
{
    protected $httpClient;

    protected function setUp()
    {
        $this->httpClient = new Client([
            'base_uri' => 'http://127.0.0.1',
            'http_errors' => false,
        ]);
    }

    public function testMustRespondWithErrorWhenAddingATaskWithShortTitle()
    {
        $response = $this->httpClient->post('/add', [
            'json' => [
                'title' => 'A'
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('message', $data);
    }

    public function testMustRespondWithErrorWhenAddingATaskWithEmptyTitle()
    {
        $response = $this->httpClient->post('/add', [
            'json' => [
                'title' => ''
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('message', $data);
    }


    public function testMustAddTaskWithSuccess()
    {
        $title = 'The title - ' . date('U');
        $response = $this->httpClient->post('/add', [
            'json' => [
                'title' => $title
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertEquals($title, $data['title']);
    }

    public function testMustAddTaskWithTagSuccessAfterCreateTag()
    {
        $tagId = 1;
        $title = 'The title - ' . date('U');
        $response = $this->httpClient->post('/add', [
            'json' => [
                'title' => $title,
                'tagId' => $tagId
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('title', $data);
        $this->assertEquals($title, $data['title']);
    }

    public function testMustGetError()
    {
        $response = $this->httpClient->post('/get', [
            'json' => [
                'id' => 0,
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('id', $data);
    }

    public function testMustGetSuccess()
    {
        $response = $this->httpClient->post('/get', [
            'json' => [
                'id' => 1,
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
    }
}
