<?php

namespace App\Domain\Stock\Domain\Events;

use App\Domain\_shared\DomainEvent;
use App\Domain\_shared\ID;
use App\Domain\Orders\Domain\ValueObjects\Period;
use App\Domain\Stock\Domain\Entities\Book;

final readonly class BookReducedFromStockEvent implements DomainEvent
{
    public function __construct(
        public Book $book,
        public ID $customerId,
        public Period $period,
    ) {
    }
}
