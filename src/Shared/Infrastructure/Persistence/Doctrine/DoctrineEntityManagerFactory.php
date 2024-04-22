<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use App\Shared\Settings\SettingsInterface;
use App\Shared\Infrastructure\Persistence\Doctrine\Dbal\DbalCustomTypesRegistrar;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\MySQLPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Schema\MySQLSchemaManager;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\ORMSetup;
use RuntimeException;

final class DoctrineEntityManagerFactory
{
    /**
     * @var array|string[]
     */
    private static array $sharedPrefixes = [
        __DIR__ . '/../../../Shared/Infrastructure/Persistence/Mappings' => 'App\Shared\Domain',
        __DIR__ . '/../../../../Register/Infrastructure/Persistence/Doctrine' => 'App\Register\Domain',
        //todo use auto parser for it
        //todo use setting
    ];

    /**
     * @param array $settings
     * @param array $contextPrefixes
     * @param array $dbalCustomTypesClasses
     *
     * @return EntityManager
     * @throws ORMException
     * @throws Exception
     */
    public static function create(
        array $settings,
        array $contextPrefixes,
        array $dbalCustomTypesClasses = []
    ): EntityManager {
        if ($dbalCustomTypesClasses) {
            DbalCustomTypesRegistrar::register($dbalCustomTypesClasses);
        }

        $config = new \Doctrine\DBAL\Configuration();

        $connection = DriverManager::getConnection([
            'dbname' => $settings['database'],
            'user' => $settings['username'],
            'password' => $settings['password'],
            'host' => $settings['host'],
            'driver' => $settings['driver'],
            'prefix' => $settings['prefix']
        ], $config);

        return EntityManager::create(
            $connection,
            self::createConfiguration($contextPrefixes, true)
        );//todo use const
    }

    /**
     * @param array $contextPrefixes
     * @param bool $isDevMode
     *
     * @return Configuration
     */
    private static function createConfiguration(array $contextPrefixes, bool $isDevMode): Configuration
    {
        $config = ORMSetup::createConfiguration($isDevMode);

        $config->setMetadataDriverImpl(new SimplifiedXmlDriver(array_merge(self::$sharedPrefixes, $contextPrefixes)));

        return $config;
    }
}
