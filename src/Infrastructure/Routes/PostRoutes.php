<?php

use Pri301\Blog\Application\Handlers\PostHandler;
use Pri301\Blog\Infarastructure\Middlewares\GetPostPartMiddleware;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

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
