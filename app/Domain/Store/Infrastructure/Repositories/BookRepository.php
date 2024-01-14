<?php

declare(strict_types=1);

namespace App\Domain\Store\Infrastructure\Repositories;

use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\Store\Domain\Entities\Book as BookEntity;
use App\Domain\Store\Domain\Repositories\StockRepositoryInterface;
use App\Models\Book as BookModel;

final readonly class BookRepository implements StockRepositoryInterface
{
    #[\Override] public function hasBook(ID $bookId): bool
    {
        return !is_null(BookModel::find($bookId->getId()));
    }

    #[\Override] public function getBook(ID $bookId): BookEntity
    {
        $bookModel = BookModel::find($bookId->getId());

        return $this->fromModelToDomain($bookModel);
    }

    public function getBooks(): array
    {
        $books = BookModel::where('quantity', '>' , 0)->get();
        $bookEntities = [];
        foreach ($books as $book) {
            $bookEntities[$book->getId()] = $this->fromModelToDomain($book);
        }

        return $bookEntities;
    }

    public function getBookByTitle(string $bookTitle): BookEntity
    {
        return $this->fromModelToDomain(BookModel::where('title', $bookTitle)->firstOrFail());
    }

    private function fromModelToDomain(BookModel $bookModel): BookEntity
    {
        return new BookEntity(
            ID::createFromInt($bookModel->id),
            $bookModel->getTitle(),
            Price::makeFromPrice($bookModel->getPrice()),
            $bookModel->getQuantity()
        );
    }

    public function save(BookEntity $rentedBook): void
    {
        $bookModel = BookModel::find($rentedBook->getId());
        $bookModel->quantity = $rentedBook->getQuantity();
        $bookModel->save();
    }

    public function increaseBookQuantityById(ID $bookId): void
    {
        $bookModel = BookModel::find($bookId);
        $bookModel->quantity = $bookModel->getQuantity() + 1;
        $bookModel->saveOrFail();
    }
}
