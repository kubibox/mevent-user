<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

use App\Shared\Domain\ValueObject\SimpleUuid;
use DateTimeImmutable;
use DateTimeInterface;

abstract class DomainEvent
{
    /**
     * @var string
     */
    private readonly string $eventId;

    /**
     * @var string
     */
    private readonly string $occurredOn;

    /**
     * @param string $aggregateId
     * @param string|null $eventId
     * @param string|null $occurredOn
     */
    private function __construct(
        private readonly string $aggregateId,
        ?string $eventId = null,
        ?string $occurredOn = null,
    ) {
        $this->eventId = $eventId ?: SimpleUuid::random()->value();
        $this->occurredOn = $occurredOn ?: (new DateTimeImmutable())->format(DateTimeInterface::ATOM);
    }

    /**
     * @param string $aggregateId
     * @param array $body
     * @param string $eventId
     * @param string $occurredOn
     *
     * @return self
     */
    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    /**
     * @return string
     */
    abstract public static function eventName(): string;

    /**
     * @return array
     */
    abstract public static function toPrimitives(): array;

    /**
     * @return string
     */
    final public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    /**
     * @return string
     */
    final public function eventId(): string
    {
        return $this->eventId;
    }

    /**
     * @return string
     */
    final public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
