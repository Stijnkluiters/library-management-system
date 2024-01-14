<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Entities;

use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\AggregateRoot;
use App\Domain\Orders\Domain\Events\BookOrderedEvent;
use App\Domain\Orders\Domain\ValueObjects\Period;

final class Book extends AggregateRoot
{
    public function __construct(
        private readonly ID $bookId,
        private readonly string $title,
        private readonly Price $price,
    ) {
    }

    public function rentBook(Customer $customer, Period $period): void
    {
        $this->addEvent(new BookOrderedEvent(
            $this->bookId,
            $customer->getCustomerId(),
            $this->price,
            $period
        ));
    }

    public function getId(): ID
    {
        return $this->bookId;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
