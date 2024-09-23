<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Events;

use App\Domain\_shared\DomainEvent;
use App\Domain\_shared\UUID;
use App\Domain\_shared\Version;
use App\Domain\Orders\Domain\Entities\OrderLine;

readonly class OrderLineAdded implements DomainEvent
{
    public function __construct(
        private UUID $orderUuid,
        private OrderLine $orderLine,
        private Version $version,
    ) {
    }

    public function getOrderUuid(): UUID
    {
        return $this->orderUuid;
    }

    public function getOrderLine(): OrderLine
    {
        return $this->orderLine;
    }

    public function getVersion(): Version
    {
        return $this->version;
    }
}
