<?php

declare(strict_types=1);

namespace App\Domain\_shared;


final class EventBus
{
    private array $subscribers = [];

    public function subscribe(string $eventName, callable $subscriber): void
    {
        $this->subscribers[$eventName][] = $subscriber;
    }

    public function publish(DomainEvent $domainEvent): void
    {
        if (isset($this->subscribers[$domainEvent::class])) {
            foreach ($this->subscribers[$domainEvent::class] as $subscriber) {
                $subscriber($domainEvent);
            }
        }
    }
}
