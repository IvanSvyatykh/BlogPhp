<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\Types\Type;
use Dotenv\Dotenv;

$config = require dirname(__DIR__) . '/config/env.php';
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Регистрация типов (если нужно)
if (!Type::hasType('boolean')) {
    Type::addType('boolean', 'Doctrine\DBAL\Types\BooleanType');
}
$paths = [__DIR__ . '/../src/Entity'];
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_pgsql',
    'host'     => $_ENV['DB_HOST'] ?? 'localhost',
    'user'     => $_ENV['DB_USER'] ??'postgres',
    'password' => $_ENV['DB_PASS'] ?? 'postgres',
    'dbname'   => $_ENV['DB_NAME'] ??'postgres',
    'port'     => $_ENV['DB_PORT'] ?? 5432,
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;