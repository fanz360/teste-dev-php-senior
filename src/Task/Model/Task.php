<?php

namespace Acme\Task\Model;


class Task
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $isDone;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isIsDone()
    {
        return $this->isDone;
    }

    /**
     * @param bool $isDone
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
    }
}