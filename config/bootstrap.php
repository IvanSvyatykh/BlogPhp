<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\Types\Type;
use Dotenv\Dotenv;


require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Регистрация типов (если нужно)
if (!Type::hasType('boolean')) {
    Type::addType('boolean', 'Doctrine\DBAL\Types\BooleanType');
}
$paths = [__DIR__ . '/../src/Domain/Entity'];
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_pgsql',
    'host'     => $_ENV['POSTGRES_DOMAIN'] ?? 'localhost',
    'user'     => $_ENV['POSTGRES_USER'] ??'postgres',
    'password' => $_ENV['POSTGRES_PASSWORD'] ?? 'postgres',
    'dbname'   => $_ENV['POSTGRES_DB'] ??'postgres',
    'port'     => $_ENV['POSTGRES_PORT'] ?? 5432,
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;