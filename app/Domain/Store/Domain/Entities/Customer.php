<?php

declare(strict_types=1);

namespace App\Domain\Store\Domain\Entities;

use App\Domain\_shared\ID;

final readonly class Customer
{
    public function __construct(
        private ID $customerId
    ) {
    }

    public static function make(ID $customerId): self
    {
        return new self($customerId);
    }

    public function getCustomerId(): ID
    {
        return $this->customerId;
    }
}
