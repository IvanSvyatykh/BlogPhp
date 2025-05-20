<?php

use Doctrine\ORM\EntityManager;
use Dotenv\Dotenv;
use Pri301\Blog\Infarastructure\Doctrine\Repositories\UserRepository;

require dirname(__DIR__) . '/vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


return [

    'db.config' => [
        'host' => $_ENV['DB_HOST'],
        'name' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS'],
        'port' => $_ENV['DB_PORT'] ?? 5432,
    ],

    EntityManager::class => function () {
        return require __DIR__ . '/bootstrap.php';
    },
    UserRepository::class => DI\autowire(),

];