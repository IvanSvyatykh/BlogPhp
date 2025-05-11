<?php

use Pri301\Blog\Handlers\PostHandler;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Pri301\Blog\Middlewares\GetPostPartMiddleware;

return function (App $app) {
    $container = $app->getContainer();
    $postHandler = $container->get(PostHandler::class);

    $app->group('/posts', function (RouteCollectorProxy $group) use ($postHandler) {
        $group->post('/filter', [$postHandler, 'getPostsBySubstr'])
            ->add(GetPostPartMiddleware::class);

        $group->post('/publish', [$postHandler, 'publishPost']);
        $group->delete('/{id}', [$postHandler, 'deletePost']);
        $group->get('/published', [$postHandler, 'getPublishedPosts']);
        $group->get('/unpublished', [$postHandler, 'getUnpublishedPosts']);
    });
};
