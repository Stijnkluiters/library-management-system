<?php

declare(strict_types=1);

namespace App\Domain\Store\Domain\Events;

use App\Domain\_shared\DomainEvent;
use App\Domain\_shared\ID;
use App\Domain\Store\Domain\Entities\Book;
use App\Domain\Store\Domain\Entities\Order;
use App\Domain\Store\Domain\ValueObjects\Period;

final readonly class BookReturnedEvent implements DomainEvent
{
    public function __construct(
        public Book $book,
        public Order $order
    ) {
    }
}
