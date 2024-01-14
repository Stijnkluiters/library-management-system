<?php

declare(strict_types=1);

namespace App\Domain\Stock\Application\Providers;

use App\Domain\_shared\EventBus;
use App\Domain\Orders\Domain\Events\BookOrderedEvent;
use App\Domain\Orders\Infrastructure\Services\OrderService;
use App\Domain\Stock\Domain\Events\BookReducedFromStockEvent;
use Illuminate\Support\ServiceProvider;

class StockServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var EventBus $eventBus */
        $eventBus = $this->app->make(EventBus::class);
        /** @var OrderService $orderService */
        $orderService = $this->app->make(OrderService::class);

        $eventBus->subscribe(BookReducedFromStockEvent::class, function (BookReducedFromStockEvent $bookOrderedEvent) use ($orderService) {
            $orderService->createOrder($bookOrderedEvent);
        });

        $this->app->bind(EventBus::class, function () use ($eventBus) {
            return $eventBus;
        });
    }
}
