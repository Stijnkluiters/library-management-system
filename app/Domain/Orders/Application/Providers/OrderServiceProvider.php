<?php

declare(strict_types=1);

namespace App\Domain\Orders\Application\Providers;

use App\Domain\_shared\EventBus;
use App\Domain\Catalog\Infrastructure\Subscribers\OrderSubscriber;
use App\Domain\Orders\Domain\Events\OrderLineAdded;
use App\Domain\Orders\Infrastructure\Repository\OrderRepository;
use App\Domain\Orders\Domain\Repository\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function boot(): void
    {
        /** @var EventBus $eventBus */
        $eventBus = $this->app->make(EventBus::class);

        $eventBus->subscribe(OrderLineAdded::class, fn($domainEvent) =>
            (app(OrderSubscriber::class))->handleOrderLineAdded($domainEvent)
        );

        $this->app->bind(EventBus::class, fn() => $eventBus);
    }
}
