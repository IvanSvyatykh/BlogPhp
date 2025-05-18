<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$paths = [__DIR__ . '/../src/Entity'];
$isDevMode = true;

// Параметры подключения к PostgreSQL
$dbParams = [
    'driver'   => 'pdo_pgsql',
    'host'     => 'localhost',
    'port'     => 5432,
    'user'     => 'your_username',
    'password' => 'your_password',
    'dbname'   => 'your_database',
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;