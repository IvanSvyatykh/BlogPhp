<?php


use Pri301\Blog\Handlers\PostHandler;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Pri301\Blog\Middlewares\GetPostPartMiddleware;

return function (App $app) {
    $app->group('/posts', function (RouteCollectorProxy $like_group) {
        $like_group->post('/filter',PostHandler::class .':getPostsBySubstr')->
        add(GetPostPartMiddleware::class);
    });
};