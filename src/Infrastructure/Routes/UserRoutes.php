<?php


use Pri301\Blog\Application\Handlers\SwitchUserBanHandler;
use Pri301\Blog\Infrastructure\Middlewares\GetUserListMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\SwitchUserActivityMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\AdminMiddleware;
use Pri301\Blog\Application\Handlers\GetUsersHandler;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/users/list', GetUsersHandler::class)
        ->add(GetUserListMiddleware::class)
        ->add(JWTMiddleware::class)
        ->add(AdminMiddleware::class);

    $app->patch('/users/banned', SwitchUserBanHandler::class)
        ->add(SwitchUserActivityMiddleware::class)
        ->add(JWTMiddleware::class)
        ->add(AdminMiddleware::class);
};
