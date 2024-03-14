<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineDIContainerFactory;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation

    $containerBuilder->addDefinitions([
//        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
    ]);
};
