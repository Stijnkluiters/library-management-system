<?php

declare(strict_types=1);

namespace App\Domain\Orders\Infrastructure\Repositories;

use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\Orders\Domain\Entities\Book;
use App\Domain\Orders\Domain\Entities\Customer;
use App\Domain\Orders\Domain\ValueObjects\Period;
use App\Domain\Orders\Domain\Entities\Order as OrderEntity;
use App\Models\Order as OrderModel;

final readonly class OrderRepository
{
    public function saveOrder(Book $book, ID $customerId, Period $period): void
    {

        OrderModel::create([
            'book_id' => $book->getId(),
            'customer_id' => $customerId,
            'price' => $book->getPrice()->getPrice(),
            'start_at' => $period->getStart(),
            'end_at' => $period->getEnd(),
        ]);
    }

    public function getOrders(): array
    {
        $orders = [];
        /** @var OrderModel $order */
        foreach(OrderModel::all() as $order) {
            $orders [] = new OrderEntity(
                ID::createFromInt($order->id),
                new Book(
                    ID::createFromInt($order->book_id),
                    $order->book->getTitle(),
                    Price::makeFromPrice($order->book->getPrice())
                ),
                new Customer(
                    ID::createFromInt($order->customer_id)
                ),
                $order->getStartAt()->toImmutable(),
                $order->getEndAt()->toImmutable()
            );
        }

        return $orders;
    }
}
