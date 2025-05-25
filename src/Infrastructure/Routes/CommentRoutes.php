<?php

use Pri301\Blog\Application\Handlers\CommentHandler;
use Pri301\Blog\Infarastructure\Middlewares\GetUserCommentsMiddleware;
use Pri301\Blog\Infarastructure\Middlewares\JWTMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/comments/by-user', CommentHandler::class . ':getUserComments')
        ->add(GetUserCommentsMiddleware::class)
        ->add(JWTMiddleware::class);
};
