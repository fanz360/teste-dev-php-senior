<?php

// Caso a aplicação tenha funcionamento somente no brasil, melhor utilizar o horário local
// Se for uma aplicação com diferentes timezones, desconsidere.

//date_default_timezone_set('UTC');
date_default_timezone_set('America/Sao_Paulo');
/*
  //Teste para identidificar horário
  print date('Y-m-d H:i:s');
  die();
 */

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->mount('/', new \Acme\Task\Controller\TaskController());

$app->run();
