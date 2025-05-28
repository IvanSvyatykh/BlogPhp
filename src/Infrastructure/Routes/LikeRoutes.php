<?php

use Pri301\Blog\Application\Handlers\ToggleLikeHandler;
use Pri301\Blog\Infrastructure\Middlewares\JWTMiddleware;
use Pri301\Blog\Infrastructure\Middlewares\ToggleLikeMiddleware;
use Slim\App;


return function (App $app) {
    #$app->get('/likes', ToggleLikeHandler::class . ':getLikes');
    $app->post('/like', ToggleLikeHandler::class)
        ->add(ToggleLikeMiddleware::class)
        ->add(JWTMiddleware::class);
    #$app->put('/like', ToggleLikeHandler::class . ':updateLike');
};