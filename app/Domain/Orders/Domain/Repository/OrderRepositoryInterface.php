<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Repository;

use App\Domain\_shared\UUID;
use App\Domain\Orders\Domain\Entities\Order;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;

    public function getAllOrdersForUser(UUID $userId): array;

    public function getOrderById(string $orderId): Order;
}