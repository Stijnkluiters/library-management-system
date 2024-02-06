<?php

declare(strict_types=1);

namespace App\Domain\Store\Domain\Events;

use App\Domain\_shared\DomainEvent;
use App\Domain\Store\Domain\Entities\Book;

final readonly class BookRevokedEvent implements DomainEvent
{
    public function __construct(
        public Book $book
    ) {
    }
}
