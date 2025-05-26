<?php

use Pri301\Blog\Application\Handlers\CreatePostHandler;
use Pri301\Blog\Application\Handlers\DeletePostHandler;
use Pri301\Blog\Application\Handlers\GetPublishedPostsHandler;
use Pri301\Blog\Application\Handlers\GetUnpublishedPostsHandler;
use Pri301\Blog\Application\Handlers\PostHandler;
use Pri301\Blog\Infrastructure\Middlewares\CreatePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetPostPartMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\DeletePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetPublishedPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetUnpublishedPostsMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/posts/published', GetPublishedPostsHandler::class)
        ->add(GetPublishedPostsMiddleware::class);

    $app->get('/posts/unpublished', GetUnpublishedPostsHandler::class)
        ->add(GetUnpublishedPostsMiddleware::class)
        ->add(JWTMiddleware::class);

    $app->delete('/posts/{id:[0-9]+}', DeletePostHandler::class)
        ->add(DeletePostMiddleware::class)
        ->add(JWTMiddleware::class);

    $app->post('/posts', CreatePostHandler::class)
        ->add(CreatePostMiddleware::class)
        ->add(JWTMiddleware::class);
};
