<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus\Event;

interface EventBus
{
    /**
     * @param DomainEvent ...$domainEvents
     *
     * @return void
     */
    public function publish(DomainEvent ...$domainEvents): void;
}
