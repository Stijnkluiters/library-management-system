<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Events;

use App\Domain\_shared\DomainEvent;
use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\Orders\Domain\ValueObjects\Period;

final readonly class BookOrderEvent implements DomainEvent
{
    public function __construct(
        private ID $bookId,
        private ID $customerId,
        private Price $price,
        private Period $period,
    ) {
    }

    public function getBookId(): ID
    {
        return $this->bookId;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getCustomerId(): ID
    {
        return $this->customerId;
    }

    public function getPeriod(): Period
    {
        return $this->period;
    }
}
