<?php

declare(strict_types=1);

namespace App\Domain\Store\Domain\Entities;

use App\Domain\_shared\ID;
use Carbon\CarbonImmutable;

final class Order
{
    public function __construct(
        private readonly ID $orderId,
        private readonly Book $book,
        private readonly Customer $customer,
        private readonly CarbonImmutable $startAt,
        private readonly CarbonImmutable $endAt,
        private ?CarbonImmutable $returnedAt = null
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

    public function getId(): ID
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

    public function isReturned(CarbonImmutable $now): void
    {
        $this->returnedAt = $now;
    }

    public function getReturnedAt(): ?CarbonImmutable
    {
        return $this->returnedAt;
    }
}
