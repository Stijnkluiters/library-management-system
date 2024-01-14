<?php

declare(strict_types=1);

namespace App\Domain\Store\Infrastructure\Services;

use App\Domain\_shared\ID;
use App\Domain\Store\Domain\Entities\Order;
use App\Domain\Store\Domain\Events\BookReturnedEvent;
use App\Domain\Warehouse\Infrastructure\Services\WarehouseService;
use App\Domain\Store\Domain\Events\BookRentedEvent;
use App\Domain\Store\Infrastructure\Repositories\BookRepository;
use App\Domain\Store\Infrastructure\Repositories\OrderRepository;

final readonly class OrderService
{
    public function __construct(
        private OrderRepository $orderRepository,
        private BookRepository $bookRepository,
        private WarehouseService $warehouseService
    ) {
    }

    public function getOrders(bool $includeReturnedOrders = false): array
    {
         return $this->orderRepository->getOrders($includeReturnedOrders);
    }

    public function getOrder(ID $orderId): Order
    {
        return $this->orderRepository->getOrder($orderId);
    }

    public function createOrder(BookRentedEvent $bookOrderedEvent): void
    {
        $this->orderRepository->createNewOrder(
            $bookOrderedEvent->book,
            $bookOrderedEvent->customerId,
            $bookOrderedEvent->period
        );
    }

    public function markOrderAsReturned(BookReturnedEvent $bookReturnedEvent): void
    {
        $this->orderRepository->markOrderAsReturned($bookReturnedEvent->order);
    }

    public function orderAtWarehouse(BookRentedEvent $bookRentedEvent): void
    {
        if ($bookRentedEvent->book->getQuantity() < 2) {
            $books = $this->warehouseService->order(
                $bookRentedEvent->book->getId(),
                3
            );

            foreach ($books as $book) {
                $this->bookRepository->increaseBookQuantityById($book);
            }
        }
    }
}
