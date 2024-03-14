<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;

Dotenv\Dotenv::createImmutable(__DIR__)->load();

$config = new PhpFile('./migrations.php');

$conn = DriverManager::getConnection([
    'dbname' => $_ENV['DB_DATABASE'],
    'user' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'host' => $_ENV['DB_HOST'],
    'driver' => $_ENV['DB_DRIVER'],
    'prefix' => $_ENV['DB_PREFIX'],
]);

try {
    $conn->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
} catch (\Doctrine\DBAL\Exception $e) {
    throw $e;
}

return DependencyFactory::fromConnection($config, new ExistingConnection($conn));
