<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Factory;

use App\Domain\_shared\UUID;
use App\Domain\_shared\Version;
use App\Domain\Orders\Domain\Entities\Order;

readonly class OrderFactory
{
    public static function createNew(): Order
    {
        return new Order(UUID::new(), new Version(1), []);
    }
}
