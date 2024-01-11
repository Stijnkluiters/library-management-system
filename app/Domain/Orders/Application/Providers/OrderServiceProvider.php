<?php

declare(strict_types=1);

namespace App\Domain\Orders\Application\Providers;

use App\Domain\_shared\EventBus;
use App\Domain\Orders\Domain\Events\BookOrderEvent;
use App\Domain\Orders\Infrastructure\Services\OrderService;
use App\Domain\Stock\Infrastructure\Services\StockService;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var EventBus $eventBus */
        $eventBus = $this->app->make(EventBus::class);
        /** @var StockService $stockService */
        $stockService = $this->app->make(StockService::class);

        $eventBus->subscribe(BookOrderEvent::class, function (BookOrderEvent $bookOrderedEvent) use ($stockService) {
            $stockService->reduceStock($bookOrderedEvent->getBookId());
        });

        $this->app->bind(EventBus::class, function () use ($eventBus) {
            return $eventBus;
        });
    }
}
