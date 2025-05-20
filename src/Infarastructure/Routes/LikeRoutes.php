<?php

use Pri301\Blog\Application\Handlers\LikeHandler;
use Slim\App;


require function (App $app) {
    $app->get('/likes', LikeHandler::class . ':getLikes');
    $app->post('/like', LikeHandler::class . ':addLike');
    $app->put('/like', LikeHandler::class . ':updateLike');
};