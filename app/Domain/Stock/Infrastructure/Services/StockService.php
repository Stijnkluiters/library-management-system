<?php

namespace App\Domain\Stock\Infrastructure\Services;

use App\Domain\_shared\EventBus;
use App\Domain\_shared\Exceptions\DomainException;
use App\Domain\_shared\ID;
use App\Domain\Orders\Domain\ValueObjects\Period;
use App\Domain\Stock\Domain\Entities\Book;
use App\Domain\Stock\Infrastructure\Exceptions\StockHasNotEnoughQuantityException;
use App\Domain\Stock\Infrastructure\Repositories\StockRepository;
use Carbon\CarbonImmutable;

final readonly class StockService
{
    public function __construct(
        private StockRepository $stockRepository,
        private EventBus $eventBus,
    ) {
    }

    /**
     * @throws DomainException
     * @throws StockHasNotEnoughQuantityException
     */
    public function reduceStock(
        ID $customerId,
        string $bookTitle,
        CarbonImmutable $start,
        CarbonImmutable $end
    ): void {
        $book = $this->stockRepository->getBookByTitle($bookTitle);
        $this->validateIfStockHas($book);

        $book->reduceStockByOne(
            $customerId,
            Period::make($start, $end)
        );

        $this->stockRepository->save($book);

        foreach ($book->getEvents() as $event) {
            $this->eventBus->publish($event);
        }
    }

    /**
     * @throws StockHasNotEnoughQuantityException
     */
    public function validateIfStockHas(string|Book $book): void
    {
        if (!$book instanceof Book) {
            $book = $this->stockRepository->getBookByTitle($book);
        }

        if ($book->getQuantity() <= 0) {
            throw StockHasNotEnoughQuantityException::create($book->getTitle());
        }
    }
}
