<?php


return [
    'db' => [
        'host' => $_ENV['DB_HOST'] ?? 'localhost',
        'name' => $_ENV['DB_NAME'] ?? 'slim_db',
        'user' => $_ENV['DB_USER'] ?? 'postgres',
        'pass' => $_ENV['DB_PASS'] ?? 'postgres',
        'port' => $_ENV['DB_PORT'] ?? '5432',
    ]
];