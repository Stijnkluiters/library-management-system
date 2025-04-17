<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Events;

use App\Domain\_shared\DomainEvent;
use App\Domain\_shared\UUID;
use App\Domain\_shared\Version;
use App\Domain\Orders\Domain\Entities\OrderLine;

readonly class OrderLineAdded implements DomainEvent
{
    /**
     * @param \App\Domain\_shared\UUID $orderUuid
     * @param \App\Domain\Orders\Domain\Entities\OrderLine $orderLine
     * @param \App\Domain\_shared\Version $version
     */
    public function __construct(
        private UUID $orderUuid,
        private OrderLine $orderLine,
        private Version $version,
    )
    {
    }

    /**
     * @return \App\Domain\_shared\UUID
     */
    public function getOrderUuid(): UUID
    {
        return $this->orderUuid;
    }

    /**
     * @return \App\Domain\Orders\Domain\Entities\OrderLine
     */
    public function getOrderLine(): OrderLine
    {
        return $this->orderLine;
    }

    /**
     * @return \App\Domain\_shared\Version
     */
    public function getVersion(): Version
    {
        return $this->version;
    }
}
