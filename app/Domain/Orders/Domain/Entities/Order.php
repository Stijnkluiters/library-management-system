<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Entities;

use App\Domain\_shared\ID;
use Carbon\CarbonImmutable;

final class Order
{
    public function __construct(
        private ID $orderId,
        private Book $book,
        private Customer $customer,
        private CarbonImmutable $startAt,
        private CarbonImmutable $endAt,
    ) {
    }

    public function getBook(): Book
    {
        return $this->book;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    public function getOrderId(): ID
    {
        return $this->orderId;
    }

    public function getStartAt(): CarbonImmutable
    {
        return $this->startAt;
    }

    public function getEndAt(): CarbonImmutable
    {
        return $this->endAt;
    }
}
