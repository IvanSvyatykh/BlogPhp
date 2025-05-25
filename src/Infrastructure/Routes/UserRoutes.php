<?php


use Pri301\Blog\Application\Handlers\LoginHandler;
use Pri301\Blog\Application\Handlers\RegisterHandler;
use Pri301\Blog\Infrastructure\Middlewares\LoginUserMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\RegisterUserMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('user',)
};
