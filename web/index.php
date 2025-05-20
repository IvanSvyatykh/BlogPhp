<?php

use DI\Bridge\Slim\Bridge;
use Doctrine\DBAL\DriverManager;
use Pri301\Blog\Application\DTO\Validator\DtoValidator;
use Pri301\Blog\Application\Handlers\PostHandler;
use Pri301\Blog\Domain\Services\PostService;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationService;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\PostRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\UserRepository;
use Slim\Factory\AppFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

require dirname(__DIR__) . '/vendor/autoload.php';
$container = require __DIR__ . '/../config/container.php';
$app = AppFactory::create(container: $container);

$container->set(PostService::class, function ($c) {
    return new PostService($c->get(PostRepository::class));
});

$container->set(RegistrationAndAuthorizationService::class, function ($c) {
    return new RegistrationAndAuthorizationService($c->get(UserRepository::class));
});

$container->set(PostHandler::class, function ($c) {
    return new PostHandler(
        $c->get(PostService::class),
        $c->get(UserRepository::class),
        $c->get(DtoValidator::class)
    );
});

$app->addBodyParsingMiddleware();

(require __DIR__ . '/../Routes/PostRoutes.php')($app);
(require __DIR__ . '/../Routes/RegistrationAndAuthorizationRoutes.php')($app);

$app->run();