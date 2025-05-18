#!/usr/bin/env php
<?php

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Symfony\Component\Console\Application;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
$entityManager = require __DIR__ . '/../config/bootstrap.php';

$config = new PhpFile(__DIR__ . '/../config/migrations.php');
$dependencyFactory = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
$entityManagerProvider = new SingleManagerProvider($entityManager);
$cli = new Application('Doctrine Migrations');
ConsoleRunner::addCommands($cli, $entityManagerProvider);
$cli->addCommands([
    new \Doctrine\Migrations\Tools\Console\Command\DiffCommand($dependencyFactory),
    new \Doctrine\Migrations\Tools\Console\Command\ExecuteCommand($dependencyFactory),
    new \Doctrine\Migrations\Tools\Console\Command\GenerateCommand($dependencyFactory),
    new \Doctrine\Migrations\Tools\Console\Command\CurrentCommand($dependencyFactory),
    new \Doctrine\Migrations\Tools\Console\Command\StatusCommand($dependencyFactory),
    new \Doctrine\Migrations\Tools\Console\Command\MigrateCommand($dependencyFactory),
]);

$cli->run();