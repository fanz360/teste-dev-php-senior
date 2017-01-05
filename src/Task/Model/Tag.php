<?php

namespace Acme\Task\Model;

/**
 * Class Tag
 * @package Acme\Task\Model
 */
class Tag extends _base
{
    /**
     * Tag constructor.
     */
    function __construct()
    {
        $this->table = 'tags';
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
            'safe' => ['id', 'name', 'color']
        ];
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $color;

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
}