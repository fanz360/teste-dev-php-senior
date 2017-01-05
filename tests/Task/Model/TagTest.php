<?php

namespace Acme\Task\Model;

use \PHPUnit_Framework_TestCase;

class TagTest extends PHPUnit_Framework_TestCase
{
    public function testMustBeInstanceOfTask()
    {
        $tag = new Tag();

        $this->assertInstanceOf('Acme\Task\Model\Tag', $tag);
    }

    public function testMustSetAndGetAttributes()
    {
        $tag = new Tag();
        $tag->setId(10);
        $tag->setName('New');
        $tag->setColor('Black');

        $this->assertEquals(10, $tag->getId());
        $this->assertEquals('New', $tag->getName());
        $this->assertEquals('Black', $tag->getColor());
    }
}
