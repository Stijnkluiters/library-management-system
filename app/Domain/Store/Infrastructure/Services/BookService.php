<?php

declare(strict_types=1);

namespace App\Domain\Store\Infrastructure\Services;

use App\Domain\Store\Infrastructure\Repositories\BookRepository;

final readonly class BookService
{
    public function __construct(
        private BookRepository $bookRepository
    ) {
    }

    public function getBooks(): array
    {
        return $this->bookRepository->getBooks();
    }
}
