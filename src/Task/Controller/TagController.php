<?php

namespace Acme\Task\Controller;

use Acme\Task\Model\Tag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Acme\Util\Database;

/**
 * Class TagController
 * @package Acme\Task\Controller
 */
class TagController implements ControllerProviderInterface {


    /**
     *  Rotas de conexão
        Define quais actions serão executadas, e o método HTTP utilizado
        GET e POST São suportados até o momento.
     *
     * @param Application $app
     * @return mixed
     */
    public function connect(Application $app) {

        $factory = $app['controllers_factory'];


        $factory->get('/','Acme\Task\Controller\TagController::listAction');
        $factory->post('/get','Acme\Task\Controller\TagController::getAction');
        $factory->post('/add','Acme\Task\Controller\TagController::createAction');
        $factory->post('/edit','Acme\Task\Controller\TagController::editAction');
        return $factory;
    }

    /**
     * NEW
     * Esta Action puxa uma tarefa pelo ID, trás consigo as informações configuradas em RULES do Model Task
     * @return JsonResponse
     */
    public function getAction()
    {
        $raw_data = file_get_contents("php://input");

        $data = json_decode($raw_data, TRUE);

        $id = isset($data['id']) ? $data['id'] : NULL;

        $model = (new Tag())->findOne($id);

        if(is_null($model))
        {
            return new JsonResponse([
                'message' => 'Search not found'
            ], 404);
        }
        else
        {
            return new JsonResponse($model->getData(), 201);
        }
    }

    /**
     * Action que retorna todas as tasks, trás consigo as informações configuradas em RULES do Model Task
     * @return JsonResponse
     */
    public function listAction()
    {
        $conn = Database::getConnection();
        $results = $conn->query('SELECT * FROM tags');
        $response = array(
            'tags' => [],
        );

        foreach ($results as $t) {
            $response['tags'][] = array(
                'id' => $t['id'],
                'name' => $t['name'],
                'color' => $t['color']
            );
        }

        return new JsonResponse($response);
    }

    /**
     * Action para criar novas Taks
     * @return JsonResponse
     */
    public function createAction()
    {
        $raw_data = file_get_contents("php://input");

        $data = json_decode($raw_data, TRUE);

        $name = isset($data['name']) ? $data['name'] : NULL;
        $color = isset($data['color']) ? $data['color'] : NULL;

        if (strlen($name) < 3) {
            return new JsonResponse([
                'message' => 'The name field must have 3 or more characters'
            ], 422);
        } else {
            $tag = new Tag();
            $tag->setName($name);
            $tag->setColor($color);

            $conn = Database::getConnection();
            $sql = "INSERT INTO tags (name, color) VALUES (:name, :color)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':color', $color);
            $stmt->execute();

            $tag->setId($conn->lastInsertId());

            return new JsonResponse([
                'id' => $tag->getId(),
                'name' => $tag->getName(),
            ], 201);
        }
    }

    /**
     * Metodo para editar a Tag, passando por ID em POST, junto com a nova Cor.
     *
     * @return JsonResponse
     */
    public function editAction()
    {
        $raw_data = file_get_contents("php://input");

        $data = json_decode($raw_data, TRUE);

        $id = isset($data['id']) ? $data['id'] : NULL;
        $color = isset($data['color']) ? $data['color'] : NULL;

        $tag = (new Tag())->findOne($id);

        if (is_null($id) || is_null($tag))
        {
            return new JsonResponse([
                'message' => 'The tag not exist'
            ], 404);
        }
        else
        {
            //$tag->setColor($color);

            $conn = Database::getConnection();
            $sql = "UPDATE tags SET color = :color WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':color', $color);
            $stmt->execute();

            return new JsonResponse([
                'id' => $tag->getId(),
                'color' => $tag->getColor(),
            ], 201);
        }
    }
}
