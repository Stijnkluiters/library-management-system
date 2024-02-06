<?php

declare(strict_types=1);

namespace App\Domain\Store\Domain\Entities;

use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;

final class Book
{
    public function __construct(
        private readonly ID $bookId,
        private readonly string $title,
        private readonly Price $price,
        private int $quantity
    ) {
    }

    public function getFullPrice(): float
    {
        return $this->price->getPriceDividedBy100();
    }

    public function getId(): ID
    {
        return $this->bookId;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function reduceQuantity(): void
    {
        $this->quantity = $this->quantity - 1;
    }

    public function increaseQuantity(): void
    {
        $this->quantity = $this->quantity + 1;
    }

    public function revokeBook(): void
    {
        $this->quantity = 0;
    }
}
