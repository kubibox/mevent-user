<?php

declare(strict_types=1);

use App\Application\Shared\Domain\Infrastructure\Doctrine\DoctrinePrefixesSearcher;
use App\Shared\Application\Settings\SettingsInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineEntityManagerFactory;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        EntityManager::class => function (ContainerInterface $c) {
            $prefixes = [
//                DoctrinePrefixesSearcher::inPath('../src/Categories', 'App\\Categories'),
//                DoctrinePrefixesSearcher::inPath('../src/Transactions', 'App\\Transactions'),
//                DoctrinePrefixesSearcher::inPath('../src/Auth', 'App\\Auth'),
            ];

            //var_dump($prefixes);exit;
            $settings = $c->get(SettingsInterface::class);


            $dbSettings = $settings->get('db');

            return DoctrineEntityManagerFactory::create(
                $dbSettings,
                $prefixes
            );
        },
    ]);
};
