<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Entities;

use App\Domain\_shared\UUID;
use App\Domain\Orders\Domain\ValueObjects\Product;

readonly class OrderLine
{
    public function __construct(
        public UUID $uuid,
        public Product $product,
        public int $amount
    ) {
    }
}
