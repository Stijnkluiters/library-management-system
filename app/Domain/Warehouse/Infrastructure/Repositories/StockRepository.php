<?php

namespace App\Domain\Stock\Infrastructure\Repositories;

use App\Domain\_shared\Exceptions\DomainException;
use App\Domain\_shared\ID;
use App\Domain\Stock\Domain\Entities\Book;
use App\Domain\Stock\Domain\Entities\Book as BookDomain;
use App\Models\Stock as StockModel;

class StockRepository
{
    private array $books = [];

    public function __construct()
    {
        foreach (StockModel::all() as $stockModel) {
            $this->books[$stockModel->getBookTitle()] = new Book(
                ID::createFromInt($stockModel->book->id),
                $stockModel->getBookTitle(),
                $stockModel->getQuantity()
            );
        }
    }

    public function getBooks(): array
    {
        $stockModels = StockModel::where('quantity', '>', 0)->get();
        $domainStockBooks = [];
        /** @var StockModel $stockModel */
        foreach ($stockModels as $stockModel) {
            $domainStockBooks[] = new Book(
                ID::createFromInt($stockModel->book->id),
                $stockModel->getBookTitle(),
                $stockModel->getQuantity()
            );
        }

        return $domainStockBooks;
    }

    public function getBookByTitle(BookDomain|string $bookTitle): ?Book
    {
        if ($bookTitle instanceof BookDomain) {
            $bookTitle = $bookTitle->getTitle();
        }

        if (isset($this->books[$bookTitle])) {
            return $this->books[$bookTitle];
        }

        throw new \DomainException('Book not found: ' . $bookTitle);
    }

    public function getBookById(ID $getBookId): Book
    {
        $bookModel = \App\Models\Book::findOrFail($getBookId->getId());

        return new Book(
            ID::createFromInt($bookModel->id),
            $bookModel->title,
            $bookModel->stock->getQuantity()
        );
    }

    public function save(BookDomain $book): void
    {
        /** @var StockModel $stockModel */
        $stockModel = StockModel::where('book_title', $book->getTitle())->firstOrFail();
        $stockModel->quantity = $book->getQuantity();
        $stockModel->save();
    }
}
