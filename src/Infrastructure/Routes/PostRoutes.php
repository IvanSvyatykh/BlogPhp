<?php

use Pri301\Blog\Application\Handlers\PostHandler;
use Pri301\Blog\Infarastructure\Middlewares\GetPostPartMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->post('/post', PostHandler::class);
};
