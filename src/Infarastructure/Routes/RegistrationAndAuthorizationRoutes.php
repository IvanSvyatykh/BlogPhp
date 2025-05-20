<?php

use Pri301\Blog\Application\Handlers\LoginHandler;
use Pri301\Blog\Application\Handlers\RegisterHandler;
use Slim\App;

return function (App $app) {
    $app->post('/register', RegisterHandler::class);
    $app->post('/login', LoginHandler::class);
};
