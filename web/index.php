<?php

use DI\Container;
use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;
use Pri301\Blog\Repositories\UserRepository;
use Pri301\Blog\Services\RegistrationAndAuthorizationService;
use Pri301\Blog\Validator\DtoValidator;
use Slim\Factory\AppFactory;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

require dirname(__DIR__) . '/vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = new Container();

$container->set(ValidatorInterface::class, function () {
    return Validation::createValidatorBuilder()
        ->enableAttributeMapping()
        ->getValidator();
});

$container->set(DtoValidator::class, function ($container) {
    return new DtoValidator($container->get(ValidatorInterface::class));
});

$container->set(UserRepository::class, function () {
    $connection = DriverManager::getConnection([
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'driver' => 'pdo_pgsql',
    ]);

    return new UserRepository($connection);
});

$container->set(RegistrationAndAuthorizationService::class, function ($c) {
    return new RegistrationAndAuthorizationService($c->get(UserRepository::class));
});

AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addBodyParsingMiddleware();
(require __DIR__ . '/../routes/PostRoutes.php')($app);
(require __DIR__ . '/../routes/RegistrationAndAuthorizationRoutes.php')($app);

$app->run();