<?php

namespace Acme\Task\Model;

/**
 * Class Task
 * @package Acme\Task\Model
 */
class Task extends _base
{

    /**
     * Task constructor.
     */
    function __construct()
    {
        $this->table = 'tasks';
        $this->rules = $this->rules();
    }

    /**
     * função de configuração para regras, futuramente pode ser add regras para tipos de valores: ex.: somente string
     * validação de email, datas, etc.
     *
     * @return array
     */
    public function rules ()
    {
        return [
            'safe' => ['id', 'description', 'isDone', 'tagId']
        ];
    }

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
     * @var bool
     */
    private $tagId;

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTagId()
    {
        return $this->tagId;
    }

    /**
     * @return _base
     */
    public function getTag()
    {
        if(!is_null($this->tagId))
        {
            // Pega as informações de tag que estão ligas a essa task
            return (new Tag())->findOne($this->tagId, 'tags', "\\Acme\\Task\\Model\\Tag");
        }
    }

    /**
     * @return bool
     */
    public function isIsDone()
    {
        return $this->isDone;
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
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param bool $isDone
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
    }

    /**
     * @param $tagId
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
    }


}