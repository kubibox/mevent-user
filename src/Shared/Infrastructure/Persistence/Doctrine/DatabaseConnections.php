<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine;

use App\Shared\Domain\Utils;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\Mapping\MappingException;

final class DatabaseConnections
{
    /**
     * @var EntityManager[]
     */
    private readonly array $connections;

    /**
     * @param iterable $connections
     */
    public function __construct(iterable $connections)
    {
        $this->connections = Utils::iterableToArray($connections);
    }

    /**
     * @throws MappingException
     */
    public function clear(): void
    {

        foreach ($this->connections as $entityManager) {
            $entityManager->clear();
        }
    }
}
