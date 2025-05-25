<?php

use Pri301\Blog\Application\Handlers\LoginHandler;
use Pri301\Blog\Application\Handlers\RegisterHandler;
use Pri301\Blog\Infrastructure\Middlewares\LoginUserMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\RegisterUserMiddleware;
use Slim\App;

return function (App $app) {
    $app->post('/register', RegisterHandler::class)->add(RegisterUserMiddleware::class);
    $app->post('/login', LoginHandler::class)->add(LoginUserMiddleware::class);
};
