<?php

declare(strict_types=1);

namespace App\Domain\_shared\ValueObjects;

use App\Domain\_shared\Exceptions\PriceCannotBeLowerThanZeroException;

final readonly class Price
{
    public function __construct(
        private int $price
    ) {
        if ($this->price < 0) {
            throw PriceCannotBeLowerThanZeroException::create($this);
        }
    }

    public static function makeFromPrice($price): self
    {
        return new self($price);
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function toHumanReadableString(): string
    {
        return number_format($this->price / 100, 2);
    }

    public function getPriceDividedBy100(): float
    {
        return ($this->price / 100);
    }
}
