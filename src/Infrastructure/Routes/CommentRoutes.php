<?php

use Pri301\Blog\Application\Handlers\CreateCommentHandler;
use Pri301\Blog\Application\Handlers\GetPostCommentsHandler;
use Pri301\Blog\Application\Handlers\GetUserCommentsHandler;
use Pri301\Blog\Infrastructure\Middlewares\CreateCommentMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetPostCommentsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetUserCommentsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;
use Slim\App;

return function (App $app) {
    $app->get('/comments/by-user', GetUserCommentsHandler::class)
        ->add(GetUserCommentsMiddleware::class)
        ->add(JWTMiddleware::class);
    $app->post('/comments', CreateCommentHandler::class)
        ->add(CreateCommentMiddleware::class)
        ->add(JWTMiddleware::class);
    $app->get('/comments/by-post', GetPostCommentsHandler::class)
        ->add(GetPostCommentsMiddleware::class)
        ->add(JWTMiddleware::class);
};
