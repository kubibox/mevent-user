<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineDIContainerFactory;
use DI\ContainerBuilder;
use App\Auth\Domain\Register\RegisterRepository;
use App\Auth\Infrastructure\Persistence\DoctrineRegisterRepository;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation

    $containerBuilder->addDefinitions([
        RegisterRepository::class => DoctrineDIContainerFactory::autowire(DoctrineRegisterRepository::class)
//        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
    ]);
};
