<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
(require __DIR__ . '/../routes/PostRoutes.php')($app);

$app->run();