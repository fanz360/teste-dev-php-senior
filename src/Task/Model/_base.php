<?php

namespace Acme\Task\Model;

use Acme\Util\Database;

/**
 * Classe de apoio para os Models
 *
 * Será possível adicionar métodos comuns aos models e assim agilizando e diminuindo repetições de códigos
 *
 * Class _base
 * @package Acme\Task\Model
 */
class _base
{
    /**
     * @var
     */
    public $table;

    /**
     * @var
     */
    public $rules;

    /**
     * @var
     */
    public $data = [];


    /**
     * Método para retornar valores de um Model através do ID
     *
     * @param $id
     * @param null $viaTable
     * @return _base|null
     */
    public function findOne($id, $viaTable = null)
    {
        if(!is_null($id))
        {
            // pega a tabela atual do model
            $table = $viaTable == null ? $this->table : $viaTable;
            // faz conecão com o banco
            $conn = Database::getConnection();
            // prepara conulta, para pegar as informações od model
            $result = $conn->prepare("SELECT * FROM {$table} WHERE id = :id");
            // add o id a consulta
            $result->bindParam(':id', $id);
            $result->execute();

            $value = $result->fetch(\PDO::FETCH_ASSOC);



            if($value !== false)
            {
                // chama a função auto fill para popular o objeto
                return $this->autoFill($value);
            }
            else
            {
                // caso o model procurado não exista
                return NULL;
            }
        }
        else
        {
            // ID não existe
            return NULL;
        }
    }

    /**
     * Metodo que tem como finalidade preencher os valores que vem do banco no Model, respeitando Rules
     *
     * @param $result
     * @return $this
     */
    public function autoFill($result)
    {
        //armazena safe de rules
        $valuesSafe = $this->rules['safe'];

        // verifica se safe foi configurado no model
        if(isset($valuesSafe))
        {
            // percorre pelos atributos marcados como safe para exibição
            foreach ($valuesSafe as $value)
            {
                // verifica se existe o valor de model no banco
                if(isset($result[$value]))
                {
                    //seta cada atributo do model
                    $this->{'set'.ucfirst($value)}($result[$value]);
                    $this->data[$value] = $result[$value];
                }
            }

            return $this;
        }
    }


    /**
     * Método para retornar valores do Model
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}