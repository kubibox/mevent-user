<?php

declare(strict_types=1);

use App\Register\Application\JWTTokenService;
use App\Shared\Domain\Infrastructure\Doctrine\DoctrinePrefixesSearcher;
use App\Shared\Settings\SettingsInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineEntityManagerFactory;
use App\TemporaryAccessToken\Domain\TemporaryAccessTokensRepository;
use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c): LoggerInterface {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        EntityManager::class => function (ContainerInterface $c): EntityManager {
            $prefixes = [
//                DoctrinePrefixesSearcher::inPath('../src/Auth', 'App\\Auth'),
//                DoctrinePrefixesSearcher::inPath('../src/Register', 'App\\Register'),
            ];

            $settings = $c->get(SettingsInterface::class);

            $dbSettings = $settings->get('db');

            return DoctrineEntityManagerFactory::create(
                $dbSettings,
                $prefixes
            );
        },
        MailerInterface::class => static function (ContainerInterface $c): MailerInterface {
            $settings = $c->get(SettingsInterface::class);

            $transport = Transport::fromDsn($settings->get('email')['dsn']);

            return new Mailer($transport);
        },
        JWTTokenService::class => function (ContainerInterface $c): JWTTokenService {
            return new JWTTokenService($c->get(SettingsInterface::class));
        },
    ]);
};
