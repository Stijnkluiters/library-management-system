<?php

declare(strict_types=1);

namespace App\Domain\Stock\Domain\Entities;

use App\Domain\_shared\ID;
use App\Domain\AggregateRoot;
use App\Domain\Orders\Domain\ValueObjects\Period;
use App\Domain\Stock\Domain\Events\BookReducedFromStockEvent;

class Book extends AggregateRoot
{
    public function __construct(
        private ID $bookId,
        private string $bookTitle,
        private int $quantity,
    ) {
    }

    public function reduceStockByOne(ID $customerId, Period $period): void
    {
        if ($this->quantity > 0) {
            $this->quantity--;
            $this->addEvent(new BookReducedFromStockEvent($this, $customerId, $period));
            return;
        }

        throw new \Exception('quantity is lower than 1');
    }

    public function getTitle(): string
    {
        return $this->bookTitle;
    }

    public function getId(): ID
    {
        return $this->bookId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
