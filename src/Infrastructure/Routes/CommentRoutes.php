<?php

use Pri301\Blog\Application\Handlers\CreateCommentHandler;
use Pri301\Blog\Application\Handlers\GetUserCommentsHandler;
use Pri301\Blog\Infrastructure\Middlewares\CreateCommentMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetUserCommentsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/comments/by-user', GetUserCommentsHandler::class) // +
        ->add(GetUserCommentsMiddleware::class)
        ->add(JWTMiddleware::class);
    $app->post('/comments', CreateCommentHandler::class)
        ->add(CreateCommentMiddleware::class)
        ->add(JWTMiddleware::class);
};
