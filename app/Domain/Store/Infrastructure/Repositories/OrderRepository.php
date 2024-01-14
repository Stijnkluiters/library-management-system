<?php

declare(strict_types=1);

namespace App\Domain\Store\Infrastructure\Repositories;

use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\Store\Domain\Entities\Book as BookEntity;
use App\Domain\Store\Domain\Entities\Customer;
use App\Domain\Store\Domain\Entities\Order as OrderEntity;
use App\Domain\Store\Domain\ValueObjects\Period;
use App\Models\Order as OrderModel;
use Carbon\CarbonImmutable;

final readonly class OrderRepository
{
    public function createNewOrder(BookEntity $book, ID $customerId, Period $period): void
    {
        OrderModel::create([
            'book_id' => $book->getId(),
            'customer_id' => $customerId,
            'price' => $book->getPrice()->getPrice(),
            'start_at' => $period->getStart(),
            'end_at' => $period->getEnd(),
        ]);
    }

    public function getOrders($includeReturnedAt = false): array
    {
        $orders = [];

        if (!$includeReturnedAt) {
            $orderModels = OrderModel::where('returned_at', null)->get();
        } else {
            $orderModels = OrderModel::all();
        }

        foreach($orderModels as $order) {
            $orders [] = $this->fromModelToDomain($order);
        }

        return $orders;
    }

    public function getOrder(ID $orderId): OrderEntity
    {
        return $this->fromModelToDomain(
            OrderModel::where('id', $orderId->getId())
                ->firstOrFail()
        );
    }

    public function fromModelToDomain(OrderModel $order): OrderEntity
    {
        return new OrderEntity(
            ID::createFromInt($order->id),
            new BookEntity(
                ID::createFromInt($order->book_id),
                $order->book->getTitle(),
                Price::makeFromPrice($order->book->getPrice()),
                $order->book->getQuantity(),
            ),
            new Customer(
                ID::createFromInt($order->customer_id)
            ),
            $order->getStartAt()->toImmutable(),
            $order->getEndAt()->toImmutable(),
            $order->getReturnedAt()?->toImmutable(),
        );
    }

    public function markOrderAsReturned(OrderEntity $order): void
    {
        $order->isReturned(CarbonImmutable::now());
        $this->saveOrder($order);
    }

    private function saveOrder(OrderEntity $orderEntity): void
    {
        /** @var OrderModel $orderModel */
        $orderModel = OrderModel::find($orderEntity->getId());
        $orderModel->returned_at = $orderEntity->getReturnedAt();
        $orderModel->saveOrFail();
    }
}
