<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Domain\Entities;

use App\Domain\_shared\UUID;
use App\Domain\_shared\ValueObjects\Price;

readonly class Product
{
    public function __construct(
        private UUID $uuid,
        private Price $price,
        private string $name
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

    public function getName(): string
    {
        return $this->name;
    }
}
