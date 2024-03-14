<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use DI\Container;
use DI\Definition\Helper\FactoryDefinitionHelper;
use Doctrine\ORM\EntityManager;
use InvalidArgumentException;

class DoctrineDIContainerFactory
{
    /**
     * @param string $class
     *
     * @return FactoryDefinitionHelper
     */
    public static function autowire(string $class): FactoryDefinitionHelper
    {
        return \DI\factory(
            static fn (Container $container) => self::write($container, $class)
        );
    }

    private static function write(Container $container, string $class): DoctrineRepository
    {
        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf('Got invalid class name: %s', $class));
        }

        return new $class($container->get(EntityManager::class));
    }
}
