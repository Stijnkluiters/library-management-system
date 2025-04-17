<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Repository;

use App\Domain\_shared\UUID;
use App\Domain\Orders\Domain\Entities\Order;
use App\Domain\Orders\Domain\ValueObjects\Product;

interface OrderRepositoryInterface
{
    /**
     * @param \App\Domain\Orders\Domain\Entities\Order $order
     *
     * @return void
     */
    public function save(Order $order): void;

    /**
     * @param \App\Domain\_shared\UUID $userId
     *
     * @return array
     */
    public function getAllOrdersForUser(UUID $userId): array;

    /**
     * @param string $orderId
     *
     * @return \App\Domain\Orders\Domain\Entities\Order
     */
    public function getOrderById(string $orderId): Order;

    /**
     * @param \App\Domain\_shared\UUID $productId
     *
     * @return \App\Domain\Orders\Domain\ValueObjects\Product
     */
    public function getProductById(UUID $productId): Product;
}
