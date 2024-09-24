<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Services;

use App\Domain\_shared\UUID;
use App\Domain\Orders\Domain\Entities\Order;
use App\Domain\Orders\Domain\Factory\OrderFactory;
use App\Domain\Orders\Domain\Repository\OrderRepositoryInterface;

readonly class OrderService
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
    ) {
    }

    public function orderProduct($productId, $amount): Order
    {
        $product = $this->orderRepository->getProductById($productId);
        $newOrder = OrderFactory::createNew();
        $newOrder->addOrderLine($product, $amount);
        $this->orderRepository->save($newOrder);

        return $newOrder;
    }

    /**
     * @return Order[]
     */
    public function getAllOrdersForUser(UUID $userId): array
    {
        return $this->orderRepository->getAllOrdersForUser($userId);
    }

    public function getOrderById(string $orderId): Order
    {
        return $this->orderRepository->getOrderById($orderId);
    }
}
