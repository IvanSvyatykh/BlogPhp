<?php

use DI\Bridge\Slim\Bridge;
use DI\Container;


require dirname(__DIR__) . '/vendor/autoload.php';
$container = new Container();
$configureContainer = require __DIR__ . '/../config/container.php';
$configureContainer($container);
$app = Bridge::create($container);

$app->addBodyParsingMiddleware();

(require __DIR__ . '/../src/Infrastructure/Routes/RegistrationAndAuthorizationRoutes.php')($app);
(require __DIR__ . '/../Routes/PostRoutes.php')($app);
$app->run();