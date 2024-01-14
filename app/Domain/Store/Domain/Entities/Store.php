<?php

declare(strict_types=1);

namespace App\Domain\Store\Domain\Entities;

use App\Domain\_shared\Exceptions\DomainException;
use App\Domain\_shared\ID;
use App\Domain\AggregateRoot;
use App\Domain\Store\Domain\Events\BookRentedEvent;
use App\Domain\Store\Domain\Events\BookReturnedEvent;
use App\Domain\Store\Domain\Repositories\StockRepositoryInterface;
use App\Domain\Store\Domain\ValueObjects\Period;

final class Store extends AggregateRoot
{
    private array $counter = [];
    public function __construct(
        private readonly StockRepositoryInterface $stock,
    ) {
    }

    /**
     * @throws DomainException
     */
    public function rentBook(ID $bookId, ID $customerId, Period $period): Book
    {
        if ($this->stock->hasBook($bookId)) {
            $book = $this->stock->getBook($bookId);

            if ($book->getQuantity() <= 0) {
                throw new DomainException("{$book->getTitle()} Does not have enough supply to be rented");
            }

            $book->reduceQuantity();

            $this->addEvent(
                new BookRentedEvent($book, $customerId, $period)
            );

            return $book;
        }

        throw new DomainException('Book has not been found!');
    }

    public function returnBook(Book $book, Order $order): Book
    {
        $book->increaseQuantity();

        $this->addEvent(new BookReturnedEvent($book, $order));

        return $book;
    }
}
