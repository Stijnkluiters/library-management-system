<?php

declare(strict_types=1);

namespace App\Domain\Stock\Infrastructure\Services;

use App\Domain\Stock\Infrastructure\Repositories\StockRepository;

final readonly class BookService
{
    public function __construct(
        private StockRepository $stockRepository
    ) {
    }

    public function getBooks(): array
    {
        return $this->stockRepository->getBooks();
    }
}
