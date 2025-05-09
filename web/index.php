<?php

use DI\Container;
use Slim\Factory\AppFactory;


require dirname(__DIR__) . '/vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

require __DIR__ . '/../src/app/routes/LikeRoutes.php';

$app->run();