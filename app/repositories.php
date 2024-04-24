<?php

declare(strict_types=1);

use App\Register\Domain\RegisterRepository;
use App\Register\Infrastructure\Persistence\DoctrineRegisterRepository;
use App\Shared\Infrastructure\Persistence\Doctrine\DoctrineDIContainerFactory;
use App\TemporaryAccessToken\Domain\TemporaryAccessTokensRepository;
use App\TemporaryAccessToken\Infrastructure\Persistence\DoctrineTemporaryAccessTokensRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation

    $containerBuilder->addDefinitions([
        RegisterRepository::class => DoctrineDIContainerFactory::autowire(DoctrineRegisterRepository::class),
        TemporaryAccessTokensRepository::class =>
            DoctrineDIContainerFactory::autowire(DoctrineTemporaryAccessTokensRepository::class),
//        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
    ]);
};
