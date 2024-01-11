<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Entities;

use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\AggregateRoot;
use App\Domain\Orders\Domain\Events\BookOrderEvent;
use App\Domain\Orders\Domain\ValueObjects\Period;
use Carbon\CarbonImmutable;

final class Book extends AggregateRoot
{
    public function __construct(
        private readonly ID $bookId,
        private readonly Price $price,
    ) {
    }

    public function rentBook(Customer $customer, Period $period): void
    {
        $this->addEvent(new BookOrderEvent(
            $this->bookId,
            $customer->getCustomerId(),
            $this->price,
            $period
        ));
    }

    public function getBookId(): ID
    {
        return $this->bookId;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}
