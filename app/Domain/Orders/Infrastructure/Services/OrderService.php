<?php

declare(strict_types=1);

namespace App\Domain\Orders\Infrastructure\Services;

use App\Domain\_shared\EventBus;
use App\Domain\_shared\ID;
use App\Domain\Orders\Domain\Entities\Customer;
use App\Domain\Orders\Domain\Exceptions\PeriodStartLaterThanStopException;
use App\Domain\Orders\Domain\ValueObjects\Period;
use App\Domain\Orders\Infrastructure\Repositories\BookRepository;
use App\Domain\Orders\Infrastructure\Repositories\OrderRepository;
use App\Domain\Stock\Domain\Events\BookReducedFromStockEvent;
use App\Domain\Stock\Infrastructure\Exceptions\StockHasNotEnoughQuantityException;
use App\Domain\Stock\Infrastructure\Services\StockService;
use Carbon\CarbonImmutable;

final readonly class OrderService
{
    public function __construct(
        private BookRepository $bookRepository,
        private OrderRepository $orderRepository,
    ) {
    }

    public function getOrders(): array
    {
         return $this->orderRepository->getOrders();
    }

    public function createOrder(BookReducedFromStockEvent $bookOrderedEvent)
    {
        $this->orderRepository->saveOrder(
            $this->bookRepository->getBookById($bookOrderedEvent->book->getId()),
            $bookOrderedEvent->customerId,
            $bookOrderedEvent->period
        );
    }
}
