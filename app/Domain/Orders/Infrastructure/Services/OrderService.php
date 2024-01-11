<?php

declare(strict_types=1);

namespace App\Domain\Orders\Infrastructure\Services;

use App\Domain\_shared\EventBus;
use App\Domain\_shared\Exceptions\PriceCannotBeLowerThanZeroException;
use App\Domain\_shared\ID;
use App\Domain\Orders\Domain\Entities\Customer;
use App\Domain\Orders\Domain\ValueObjects\Period;
use App\Domain\Orders\Infrastructure\Repositories\BookRepository;
use App\Domain\Orders\Infrastructure\Repositories\OrderRepository;
use Carbon\CarbonImmutable;

final readonly class OrderService
{
    public function __construct(
        private BookRepository $bookRepository,
        private OrderRepository $orderRepository,
        private EventBus $eventBus,
    ) {
    }

    public function orderBook(ID $customerId, string $bookTitle, CarbonImmutable $start, CarbonImmutable $end)
    {
        $book = $this->bookRepository->getBookByTitle($bookTitle);
        $customer = Customer::make($customerId);
        $period = Period::make($start, $end);

        $book->rentBook($customer, $period);

        $this->orderRepository->saveOrder($book, $customer, $period);

        foreach ($book->getEvents() as $domainEvent) {
            $this->eventBus->publish($domainEvent::class, $domainEvent);
        }
    }
}
