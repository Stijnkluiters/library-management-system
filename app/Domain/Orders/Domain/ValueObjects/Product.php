<?php

namespace App\Domain\Orders\Domain\ValueObjects;

use App\Domain\_shared\UUID;
use App\Domain\_shared\ValueObjects\Price;

readonly class Product
{
    public function __construct(
        private UUID $uuid,
        private Price $price,
        private string $name,
    ) {
    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
    public function getPriceAsInteger(): int
    {
        return $this->price->getPrice();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
