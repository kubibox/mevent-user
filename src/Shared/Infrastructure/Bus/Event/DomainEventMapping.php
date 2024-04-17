<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use App\Shared\Domain\Bus\Event\DomainEventSubscriber;
use RuntimeException;

use function Lambdish\Phunctional\reduce;
use function Lambdish\Phunctional\reindex;

final class DomainEventMapping
{
    /**
     * @var array
     */
    private array $mapping;

    /**
     * @param iterable $mapping
     */
    public function __construct(iterable $mapping)
    {
        $this->mapping = reduce($this->eventsExtractor(), $mapping, []);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function for(string $name): string
    {
        if (!isset($this->mapping[$name])) {
            throw new RuntimeException("The Domain Event Class for <$name> doesn't exists or have no subscribers");
        }

        return $this->mapping[$name];
    }

    /**
     * @return callable
     */
    private function eventsExtractor(): callable
    {
        return fn(array $mapping, DomainEventSubscriber $subscriber): array => array_merge(
            $mapping,
            reindex($this->eventNameExtractor(), $subscriber::subscribedTo())
        );
    }

    /**
     * @return callable
     */
    private function eventNameExtractor(): callable
    {
        return static fn(string $eventClass): string => $eventClass::eventName(); //todo check
    }
}
