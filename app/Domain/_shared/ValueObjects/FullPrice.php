<?php

namespace App\Domain\_shared\ValueObjects;

readonly class FullPrice
{
    /**
     * @param Price[] $prices
     */
    public function __construct(
        private array $prices
    ) {
    }

    public function getPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->prices as $price) {
            $totalPrice += $price->getPrice();
        }
        return $totalPrice;
    }
}
