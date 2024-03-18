<?php

declare(strict_types=1);

use App\Shared\Settings\Settings;
use App\Shared\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return static function (ContainerBuilder $containerBuilder) {
    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError' => false,
                'logErrorDetails' => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : dirname(__DIR__) . '/logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                'dev' => !($_ENV['PROD'] ?? false),
                'db' => [
                    'driver' => $_ENV['DB_DRIVER'],
                    'host' => $_ENV['DB_HOST'],
                    'database' => $_ENV['DB_DATABASE'],
                    'username' => $_ENV['DB_USERNAME'],
                    'password' => $_ENV['DB_PASSWORD'],
                    'charset' => $_ENV['DB_CHARSET'],
                    'collation' => $_ENV['DB_COLLATION'],
                    'prefix' => $_ENV['DB_PREFIX'],
                ],
                'email' => [
                    'dsn' => $_ENV['MAILER_DSN'],
                    'encryption' => $_ENV['MAIL_ENCRYPTION']
                ],
                'root_path' => dirname(__DIR__),
                'rsa' => [
                    'private' => 'rsa-private-key.pem',
                    'public' => 'rsa-public-key.pem'
                ],
                'app_name' => $_ENV['APP_NAME']
            ]);
        },
    ]);
};
