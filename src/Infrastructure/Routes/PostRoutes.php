<?php

use Pri301\Blog\Application\Handlers\CreatePostHandler;
use Pri301\Blog\Application\Handlers\GetUnpublishedPostsHandler;
use Pri301\Blog\Application\Handlers\PostHandler;
use Pri301\Blog\Application\Handlers\GetPostsHandler;
use Pri301\Blog\Application\Handlers\RejectPostHandler;
use Pri301\Blog\Application\Handlers\PublishPostHandler;
use Pri301\Blog\Infrastructure\Middlewares\CreatePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\AdminPostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\DeletePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetPublishedPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetUnpublishedPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetAllPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\AdminMiddleware;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->get('/posts/published', [PostHandler::class, 'getPublishedPosts'])
        ->add(GetPublishedPostsMiddleware::class);

    $app->get('/posts/unpublished', GetUnpublishedPostsHandler::class)
        ->add(GetUnpublishedPostsMiddleware::class)
        ->add(JWTMiddleware::class);

    $app->delete('/posts/{id:[0-9]+}', PostHandler::class . ':deletePost')
        ->add(DeletePostMiddleware::class)
        ->add(JWTMiddleware::class);

    $app->post('/posts', CreatePostHandler::class)
        ->add(CreatePostMiddleware::class)
        ->add(JWTMiddleware::class);

    $app->get('/posts/list', GetPostsHandler::class)
        ->add(GetAllPostsMiddleware::class)
        ->add(JWTMiddleware::class)
        ->add(AdminMiddleware::class);

    $app->patch('/posts/publish', PublishPostHandler::class)
        ->add(AdminPostMiddleware::class)
        ->add(JWTMiddleware::class)
        ->add(AdminMiddleware::class);

    $app->patch('/posts/reject', RejectPostHandler::class)
        ->add(AdminPostMiddleware::class)
        ->add(JWTMiddleware::class)
        ->add(AdminMiddleware::class);
};
