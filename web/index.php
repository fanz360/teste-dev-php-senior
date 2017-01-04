<?php

date_default_timezone_set('UTC');

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->mount('/', new \Acme\Task\Controller\TaskController());

$app->run();
