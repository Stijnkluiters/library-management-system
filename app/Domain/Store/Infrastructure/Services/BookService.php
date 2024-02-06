<?php

declare(strict_types=1);

namespace App\Domain\Store\Infrastructure\Services;

use App\Domain\_shared\ID;
use App\Domain\Store\Domain\Entities\Book as BookEntity;
use App\Domain\Store\Infrastructure\Exceptions\BookAlreadyExistException;
use App\Domain\Store\Infrastructure\Repositories\BookRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class BookService
{
    public function __construct(
        private BookRepository $bookRepository
    ) {
    }

    /**
     * @throws BookAlreadyExistException
     */
    public function create(array $bookAttributes): BookEntity
    {
        $this->validateIfBookUnique($bookAttributes['title']);
        //TODO: Convert price to cents in separate class when repeated.
        $bookAttributes['price'] *= 100;

        return $this->bookRepository->create($bookAttributes);
    }

    public function getBooks(): array
    {
        return $this->bookRepository->getBooks();
    }

    public function getBookById(ID $bookId): BookEntity
    {
        return $this->bookRepository->getBook($bookId);
    }

    /**
     * @throws BookAlreadyExistException
     */
    public function update(
        BookEntity $originalBook,
        array $bookAttributes
    ): BookEntity
    {
        if ($originalBook->getTitle() !== $bookAttributes['title']) {
            $this->validateIfBookUnique($bookAttributes['title']);
        }


        if (isset($bookAttributes['price'])) {
            $bookAttributes['price'] *= 100;
        }

        return $this->bookRepository->updateBook($originalBook, $bookAttributes);
    }

    /**
     * @throws BookAlreadyExistException
     */
    private function validateIfBookUnique(string $title): void
    {
        $existingBook = null;
        try {
            $existingBook = $this->bookRepository->getBookByTitle($title);
        } catch (ModelNotFoundException) {
            // good!
        }
        if (!is_null($existingBook)) {
            throw BookAlreadyExistException::fromTitle($title);
        }
    }
}
