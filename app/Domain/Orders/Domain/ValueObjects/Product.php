<?php

namespace App\Domain\Orders\Domain\ValueObjects;

use App\Domain\_shared\UUID;
use App\Domain\_shared\ValueObjects\Price;

readonly class Product
{
    /**
     * @param \App\Domain\_shared\UUID $uuid
     * @param \App\Domain\_shared\ValueObjects\Price $price
     * @param string $name
     */
    public function __construct(
        private UUID $uuid,
        private Price $price,
        private string $name,
    ) {
    }

    /**
     * @return \App\Domain\_shared\UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return \App\Domain\_shared\ValueObjects\Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getPriceAsInteger(): int
    {
        return $this->price->getPrice();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
