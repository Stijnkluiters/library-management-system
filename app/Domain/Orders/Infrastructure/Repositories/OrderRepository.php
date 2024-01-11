<?php

declare(strict_types=1);

namespace App\Domain\Orders\Infrastructure\Repositories;

use App\Domain\Orders\Domain\Entities\Book;
use App\Domain\Orders\Domain\Entities\Customer;
use App\Domain\Orders\Domain\Events\BookOrderEvent;
use App\Domain\Orders\Domain\ValueObjects\Period;
use App\Models\Order;

final readonly class OrderRepository
{
    public function saveOrder(Book $book, Customer $customer, Period $period): void
    {
        Order::create([
            'book_id' => $book->getBookId(),
            'customer_id' => $customer->getCustomerId(),
            'price' => $book->getPrice()->getPrice(),
            'start_at' => $period->getStart(),
            'end_at' => $period->getEnd(),
        ]);
    }
}
