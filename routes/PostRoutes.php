<?php


use Pri301\Blog\Handlers\PostHandler;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;


require function (App $app) {
    $app->group('/post', function (RouteCollectorProxy $like_group) {
        $like_group->get('/filter', PostHandler::class . ':getPostsBySubstr');
    });
};