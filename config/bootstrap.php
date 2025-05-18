<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\Types\Type;




require_once __DIR__ . '/../vendor/autoload.php';


// Регистрация типов (если нужно)
if (!Type::hasType('boolean')) {
    Type::addType('boolean', 'Doctrine\DBAL\Types\BooleanType');
}
$paths = [__DIR__ . '/../src/Entity'];
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_pgsql',
    'host'     => 'localhost',
    'user'     => 'postgres',
    'password' => 'postgres',
    'dbname'   => 'postgres',
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;