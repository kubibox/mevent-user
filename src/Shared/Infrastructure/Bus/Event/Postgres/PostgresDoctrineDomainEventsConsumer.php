<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event\Postgres;

use App\Shared\Infrastructure\Bus\Event\DomainEventMapping;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

use Exception;
use RuntimeException;
use function Lambdish\Phunctional\each;
use function Lambdish\Phunctional\map;

final readonly class PostgresDoctrineDomainEventsConsumer
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param EntityManager $entityManager
     * @param DomainEventMapping $eventMapping
     */
    public function __construct(EntityManager $entityManager, private DomainEventMapping $eventMapping)
    {
        $this->connection = $entityManager->getConnection();
    }

    /**
     * @param callable $subscribers
     * @param int $eventsToConsume
     *
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function consume(callable $subscribers, int $eventsToConsume): void
    {
        $events = $this->connection
            ->executeQuery("SELECT * FROM domain_events ORDER BY occurred_on ASC LIMIT $eventsToConsume")
            ->fetchAllAssociative();

        each($this->executeSubscribers($subscribers), $events);

        $ids = implode(', ', map($this->idExtractor(), $events));

        if (!empty($ids)) {
            $this->connection->executeStatement("DELETE FROM domain_events WHERE id IN ($ids)");
        }
    }

    private function executeSubscribers(callable $subscribers): callable
    {
        return function (array $rawEvent) use ($subscribers): void {
            try {
                $domainEventClass = $this->eventMapping->for($rawEvent['name']);
                $domainEvent = $domainEventClass::fromPrimitives(
                    $rawEvent['aggregate_id'],
                    \json_decode($rawEvent['body'], true),
                    $rawEvent['id'],
                    $this->formatDate($rawEvent['occurred_on'])
                );

                $subscribers($domainEvent);
            } catch (RuntimeException) {
            }
        };
    }

    /**
     * @param mixed $stringDate
     *
     * @return string
     * @throws Exception
     */
    private function formatDate(mixed $stringDate): string
    {
        return (new DateTimeImmutable($stringDate))->format(DateTimeInterface::ATOM);
    }

    /**
     * @return callable
     */
    private function idExtractor(): callable
    {
        return static fn (array $event): string => "'{$event['id']}'";
    }
}
