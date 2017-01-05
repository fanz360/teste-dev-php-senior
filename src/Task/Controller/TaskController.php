<?php

namespace Acme\Task\Controller;

use Acme\Task\Model\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Acme\Util\Database;

/**
 * Class TaskController
 * @package Acme\Task\Controller
 */
class TaskController implements ControllerProviderInterface {

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
        $factory->get('/','Acme\Task\Controller\TaskController::listAction');
        $factory->post('/get','Acme\Task\Controller\TaskController::getAction');
        $factory->post('/add','Acme\Task\Controller\TaskController::createAction');
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

        $model = (new Task())->findOne($id);

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
        $results = $conn->query('SELECT * FROM tasks');
        $response = array(
            'tasks' => [],
        );

        foreach ($results as $t) {
            $response['tasks'][] = array(
                'id' => $t['id'],
                'title' => $t['description'],
                'tagId' => $t['tagId'],
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

        $title = isset($data['title']) ? $data['title'] : NULL;
        $tagId = isset($data['tagId']) ? $data['tagId'] : NULL;

        if (strlen($title) < 3) {
            return new JsonResponse([
                'message' => 'The title field must have 3 or more characters'
            ], 422);
        } else {
            $task = new Task();
            $task->setDescription($title);
            $task->setTagId($tagId);

            $conn = Database::getConnection();
            $sql = "INSERT INTO tasks (description, tagId) VALUES (:title, :tagId)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':tagId', $tagId);
            $stmt->execute();

            $task->setId($conn->lastInsertId());

            // Valores de retorno
            return new JsonResponse([
                'id' => $task->getId(),
                'title' => $task->getDescription(),
                'tagId' => $task->getTagId()
            ], 201);
        }
    }
}
