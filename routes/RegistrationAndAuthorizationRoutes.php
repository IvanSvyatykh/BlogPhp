<?php

use Pri301\Blog\Handlers\LoginHandler;
use Pri301\Blog\Handlers\RegisterHandler;
use Slim\App;

return function (App $app) {
    $app->post('/register', RegisterHandler::class);
    $app->post('/login', LoginHandler::class);
};
