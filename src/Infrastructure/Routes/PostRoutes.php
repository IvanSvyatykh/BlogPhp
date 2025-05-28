<?php

use Pri301\Blog\Application\Handlers\CreatePostHandler;
use Pri301\Blog\Application\Handlers\DeletePostHandler;
use Pri301\Blog\Application\Handlers\GetAllUnpublishedHandler;
use Pri301\Blog\Application\Handlers\GetCategoriesHandler;
use Pri301\Blog\Application\Handlers\GetPublishedPostsHandler;
use Pri301\Blog\Application\Handlers\GetUnpublishedPostsHandler;
use Pri301\Blog\Application\Handlers\PostHandler;
use Pri301\Blog\Application\Handlers\GetPostsHandler;
use Pri301\Blog\Application\Handlers\RejectPostHandler;
use Pri301\Blog\Application\Handlers\PublishPostHandler;
use Pri301\Blog\Infrastructure\Middlewares\CreatePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\AdminPostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetPostsBySubstrMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\DeletePostMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetPublishedPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetUnpublishedPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\GetAllPostsMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\AdminMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\PublishPostMiddleware;
use Slim\App;
use Pri301\Blog\Application\Handlers\GetPostsBySubstrHandler;
return function (App $app) {
    $app->get('/posts/published', GetPublishedPostsHandler::class) // +
        ->add(GetPublishedPostsMiddleware::class);

    $app->get('/posts/unpublished', GetUnpublishedPostsHandler::class) // +
        ->add(GetUnpublishedPostsMiddleware::class)
        ->add(JWTMiddleware::class);

    $app->delete('/posts/{id:[0-9]+}', DeletePostHandler::class) // Добавить чеки на модератора и админа
        ->add(DeletePostMiddleware::class)
        ->add(JWTMiddleware::class);

    $app->post('/posts', CreatePostHandler::class) // +
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
    $app->get('/categories', GetCategoriesHandler::class);


    $app->get('/post/substr' , GetPostsBySubstrHandler::class)
        ->add(GetPostsBySubstrMiddleware::class);

    $app->get('/posts/unpublished/all', GetAllUnpublishedHandler::class)
        ->add(JWTMiddleware::class);
};
