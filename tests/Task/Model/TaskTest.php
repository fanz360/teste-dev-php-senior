<?php

namespace Acme\Task\Model;

use \PHPUnit_Framework_TestCase;

class TaskTest extends PHPUnit_Framework_TestCase
{
    public function testMustBeInstanceOfTask()
    {
        $task = new Task();

        $this->assertInstanceOf('Acme\Task\Model\Task', $task);
    }

    public function testMustSetAndGetAttributes()
    {
        $task = new Task();
        $task->setId(10);
        $task->setDescription('Hello world!');

        $this->assertEquals(10, $task->getId());
        $this->assertEquals('Hello world!', $task->getDescription());
    }
}
