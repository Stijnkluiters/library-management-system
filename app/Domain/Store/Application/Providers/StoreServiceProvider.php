<?php

declare(strict_types=1);

namespace App\Domain\Store\Application\Providers;

use App\Domain\_shared\EventBus;
use App\Domain\Store\Domain\Events\BookRentedEvent;
use App\Domain\Store\Domain\Events\BookReturnedEvent;
use App\Domain\Store\Domain\Repositories\StockRepositoryInterface;
use App\Domain\Store\Infrastructure\Repositories\BookRepository;
use App\Domain\Store\Infrastructure\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class StoreServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerRepositories();
        $this->registerEvents();
    }

    private function registerRepositories(): void
    {
        $this->app->bind(StockRepositoryInterface::class, fn() => new BookRepository());
    }

    private function registerEvents(): void
    {
        /** @var EventBus $eventBus */
        $eventBus = $this->app->make(EventBus::class);
        /** @var OrderService $orderService */
        $orderService = $this->app->make(OrderService::class);

        $eventBus->subscribe(BookRentedEvent::class, function (BookRentedEvent $bookRentedEvent) use ($orderService) {
            $orderService->createOrder($bookRentedEvent);
            $orderService->orderAtWarehouse($bookRentedEvent);
        });

        $eventBus->subscribe(BookReturnedEvent::class, function (BookReturnedEvent $bookReturnedEvent) use ($orderService) {
            $orderService->markOrderAsReturned($bookReturnedEvent);
        });

        $this->app->bind(EventBus::class, function () use ($eventBus) {
            return $eventBus;
        });
    }
}
