<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Entities;

use App\Domain\_shared\UUID;
use App\Domain\_shared\Version;
use App\Domain\AggregateRoot;
use App\Domain\Orders\Domain\Events\OrderLineAdded;
use App\Domain\Orders\Domain\ValueObjects\Product;

class Order extends AggregateRoot
{
    public function __construct(
        private readonly UUID $uuid,
        private Version $version,
        private array $orderLines,
    ) {
    }

    public function addOrderLine(Product $product, int $amount): void
    {
        $orderLine = new OrderLine(UUID::new(), $product, $amount);
        $this->orderLines[] = $orderLine;
        $this->addEvent(new OrderLineAdded(
            $this->uuid,
            $orderLine,
            new Version($this->version->getVersionNumber() + 1)
        ));
    }

    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    public function getOrderLines(): array
    {
        return $this->orderLines;
    }
}
