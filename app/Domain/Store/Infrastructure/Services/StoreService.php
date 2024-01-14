<?php

declare(strict_types=1);

namespace App\Domain\Store\Infrastructure\Services;

use App\Domain\_shared\EventBus;
use App\Domain\_shared\Exceptions\DomainException;
use App\Domain\_shared\ID;
use App\Domain\Store\Domain\Entities\Store;
use App\Domain\Store\Domain\ValueObjects\Period;
use App\Domain\Store\Infrastructure\Repositories\BookRepository;
use App\Domain\Store\Domain\Entities\Book;
use App\Domain\Store\Domain\Entities\Stock;
use Carbon\Carbon;

final readonly class StoreService
{
    private Store $store;

    public function __construct(
        private BookRepository $bookRepository,
        private OrderService $orderService,
        private EventBus $eventBus,
    ) {
        $this->store = new Store($this->bookRepository);
    }

    /**
     * @throws DomainException
     */
    public function rentBook(string $bookTitle, ID $customerId, Period $period): Book
    {
        $book = $this->bookRepository->getBookByTitle($bookTitle);

        $rentedBook = $this->store->rentBook($book->getId(), $customerId, $period);

        $this->bookRepository->save($rentedBook);

        $this->publishEvents();

        return $rentedBook;
    }

    public function returnBook(string $bookTitle, ID $orderId): Book
    {
        $book = $this->bookRepository->getBookByTitle($bookTitle);

        $order = $this->orderService->getOrder($orderId);

        // todo: add fine for a dollar per week.
        $returnedBook = $this->store->returnBook($book, $order);

        $this->bookRepository->save($returnedBook);

        $this->publishEvents();

        return $returnedBook;
    }

    private function publishEvents(): void
    {
        foreach ($this->store->getEvents() as $event) {
            $this->eventBus->publish($event);
        }
    }
}
