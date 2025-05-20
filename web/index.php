<?php

use DI\Bridge\Slim\Bridge;
use Doctrine\DBAL\DriverManager;
use Pri301\Blog\Application\Handlers\PostHandler;
use Pri301\Blog\Domain\Services\PostService;
use Pri301\Blog\Domain\Services\RegistrationAndAuthorizationService;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\PostRepository;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\UserRepository;
use Pri301\Blog\Validator\DtoValidator;
use Slim\Factory\AppFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

require dirname(__DIR__) . '/vendor/autoload.php';
$app = Bridge::create(require __DIR__ . '/../config/container.php');

$container = new Container();

$container->set(ValidatorInterface::class, function () {
    return Validation::createValidatorBuilder()
        ->enableAttributeMapping()
        ->getValidator();
});

$container->set(DtoValidator::class, function ($container) {
    return new DtoValidator($container->get(ValidatorInterface::class));
});

$container->set('db.connection', function () {
    return DriverManager::getConnection([
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'driver' => 'pdo_pgsql',
    ]);
});

$container->set(UserRepository::class, function ($c) {
    return new UserRepository($c->get('db.connection'));
});

$container->set(PostRepository::class, function ($c) {
    return new PostRepository(
        $c->get('db.connection'),
        $c->get(UserRepository::class)
    );
});

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

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();

(require __DIR__ . '/../Routes/PostRoutes.php')($app);
(require __DIR__ . '/../Routes/RegistrationAndAuthorizationRoutes.php')($app);

$app->run();