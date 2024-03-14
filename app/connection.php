<?php

declare(strict_types=1);

use App\Shared\Application\Settings\SettingsInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineEntityManagerFactory;
use Psr\Container\ContainerInterface;

/**
 * @example array 'db' => [
 * 'driver' => $_ENV['DB_DRIVER'],
 * 'host' => $_ENV['DB_HOST'],
 * 'database' => $_ENV['DB_DATABASE'],
 * 'username' => $_ENV['DB_USERNAME'],
 * 'password' => $_ENV['DB_PASSWORD'],
 * 'charset' => $_ENV['DB_CHARSET'],
 * 'collation' => $_ENV['DB_COLLATION'],
 * 'prefix' => $_ENV['DB_PREFIX'],
 * ]
 */

return function (ContainerInterface $c) {
    $prefixes = [
//        DoctrinePrefixesSearcher::inPath('../src/Categories', 'App\\Categories'),
//        DoctrinePrefixesSearcher::inPath('../src/Transactions', 'App\\Transactions'),
//        DoctrinePrefixesSearcher::inPath('../src/Auth', 'App\\Auth'),
    ];

    $settings = $c->get(SettingsInterface::class);

    $dbSettings = $settings->get('db');

    return DoctrineEntityManagerFactory::create(
        $dbSettings,
        $prefixes
    );
};
