<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Domain\Entities;

use App\Domain\_shared\UUID;
use App\Domain\_shared\ValueObjects\Price;

/**
 * Product entity of the catalog
 */
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
        private string $name
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
