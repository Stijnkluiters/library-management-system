<?php

declare(strict_types=1);

namespace App\Domain\Orders\Domain\Services;

use App\Domain\_shared\UUID;
use App\Domain\Catalog\Application\ShoppingCartItems;
use App\Domain\Orders\Domain\Entities\Order;
use App\Domain\Orders\Domain\Factory\OrderFactory;
use App\Domain\Orders\Domain\Repository\OrderRepositoryInterface;

readonly class OrderService
{
    /**
     * @param \App\Domain\Orders\Domain\Repository\OrderRepositoryInterface $orderRepository
     */
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
    ) {
    }

    /**
     * @param UUID $productId
     * @param int $amount
     *
     * @return \App\Domain\Orders\Domain\Entities\Order
     */
    public function orderProduct(UUID $productId, int $amount): Order
    {
        $product = $this->orderRepository->getProductById($productId);
        $newOrder = OrderFactory::createNew();
        $newOrder->addOrderLine($product, $amount);
        $this->orderRepository->save($newOrder);

        return $newOrder;
    }

    /**
     * @param \App\Domain\_shared\UUID $userId
     *
     * @return \App\Domain\Orders\Domain\Entities\Order[]
     */
    public function getAllOrdersForUser(UUID $userId): array
    {
        return $this->orderRepository->getAllOrdersForUser($userId);
    }

    /**
     * @param string $orderId
     *
     * @return \App\Domain\Orders\Domain\Entities\Order
     */
    public function getOrderById(string $orderId): Order
    {
        return $this->orderRepository->getOrderById($orderId);
    }

    /**
     * @param \App\Domain\Catalog\Application\ShoppingCartItems $shoppingCartItems
     *
     * @return \App\Domain\Orders\Domain\Entities\Order
     */
    public function orderByShoppingCartItems(ShoppingCartItems $shoppingCartItems): Order
    {
        $newOrder = OrderFactory::createNew();

        foreach ($shoppingCartItems as $uuid) {
            $product = $this->orderRepository->getProductById($uuid);
            $newOrder->addOrderLine($product, 1);
        }

        $this->orderRepository->save($newOrder);

        return $newOrder;
    }
}
