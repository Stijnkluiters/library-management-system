<?php

declare(strict_types=1);

namespace App\Domain\Orders\Infrastructure\Repository;

use App\Domain\_shared\UUID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\_shared\Version;
use App\Domain\Orders\Domain\Entities\Order;
use App\Domain\Orders\Domain\Entities\OrderLine;
use App\Domain\Orders\Domain\Events\OrderLineAdded;
use App\Domain\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Domain\Orders\Domain\ValueObjects\Product;
use Nette\NotImplementedException;
use App\Models\Order as OrderModel;
use App\Models\OrderLine as OrderLineModel;

readonly class OrderRepository implements OrderRepositoryInterface
{
    public function save(Order $order): void
    {
        foreach ($order->getEvents() as $domainEvent) {
            match (get_class($domainEvent)) {
                OrderLineAdded::class => $this->storeOrderLineAdded($domainEvent),
                default => throw new NotImplementedException('Storing of domain-event not implemented: ' . get_class($domainEvent)),
            };
        }
    }

    private function storeOrderLineAdded(OrderLineAdded $domainEvent): void
    {
        $product = $domainEvent->getOrderLine()->product;

        $orderLineModel = OrderLineModel::create([
            'uuid' => $domainEvent->getOrderLine()->uuid,
            'amount' => $domainEvent->getOrderLine()->amount,
            'price' => $product->getPriceAsInteger(), // todo:
            'product_id' => $product->getUuid(),
            'name' => $product->getName(),
        ]);
        $orderModel = OrderModel::firstOrCreate(
            [
                'uuid' => $domainEvent->getOrderUuid(),
            ],
            [
                'uuid' => $domainEvent->getOrderUuid(),
                'version' => $domainEvent->getVersion(),
            ]
        );

        $orderModel->orderLines()->saveMany([$orderLineModel]);
    }

    /**
     * @param UUID $userId
     * @return Order[]
     */
    public function getAllOrdersForUser(UUID $userId): array
    {
        $orderModels = OrderModel::with('orderLines')->where('user_id', $userId)->get();

        return $orderModels->map(fn (OrderModel $orderModel) => $this->fromModelToDomain($orderModel))->toArray();
    }

    private function fromModelToDomain(OrderModel $orderModel): Order
    {
        $orderLines = [];
        // todo: create factory for easier mapping
        foreach ($orderModel->orderLines as $orderLineModel) {
            $orderLines[] = new OrderLine(
                UUID::createFromString($orderLineModel->uuid),
                new Product(
                    UUID::createFromString($orderLineModel->product->uuid),
                    new Price($orderLineModel->price),
                    $orderLineModel->name
                ),
                $orderLineModel->amount,
            );
        }

        return new Order(
            UUID::createFromString($orderModel->uuid),
            new Version($orderModel->version ?? 1),
            $orderLines
        );
    }

    public function getOrderById(string $orderId): Order
    {
        $order = OrderModel::findOrFail($orderId);

        return $this->fromModelToDomain($order);
    }
}
