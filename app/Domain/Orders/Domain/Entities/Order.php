<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Entities;

use App\Domain\_shared\UUID;
use App\Domain\_shared\Version;
use App\Domain\AggregateRoot;
use App\Domain\Orders\Domain\Events\OrderLineAdded;
use App\Domain\Orders\Domain\ValueObjects\Product;
use App\Models\User;

class Order extends AggregateRoot
{
    /**
     * @param \App\Domain\_shared\UUID $uuid
     * @param \App\Domain\_shared\Version $version
     * @param \App\Domain\Orders\Domain\Entities\OrderLine[] $orderLines
     */
    public function __construct(
        private readonly UUID $uuid,
        private readonly Version $version,
        private array $orderLines,
    ) {
    }

    /**
     * @param \App\Domain\Orders\Domain\ValueObjects\Product $product
     * @param int $amount
     *
     * @return void
     */
    public function addOrderLine(Product $product, int $amount): void
    {
        $orderLine = new OrderLine(UUID::new(), $product, $amount);
        $this->orderLines[] = $orderLine;
        $this->addEvent(new OrderLineAdded(
            $this->uuid,
            User::query()->first()->uuid, // todo: login before ordering
            $orderLine,
            new Version($this->version->getVersionNumber() + 1)
        ));
    }

    /**
     * @return \App\Domain\_shared\UUID
     */
    public function getUuid(): UUID
    {
        return $this->uuid;
    }

    /**
     * @return array
     */
    public function getOrderLines(): array
    {
        return $this->orderLines;
    }
}
