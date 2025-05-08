<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


require dirname(__DIR__) . '/vendor/autoload.php';
$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $data = array('name' => 'Max', 'role' => 'web developer');
    $response->getBody()->write(json_encode($data));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();