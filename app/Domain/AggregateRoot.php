<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\_shared\DomainEvent;

class AggregateRoot
{
    protected array $events;

    public function addEvent(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return DomainEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
