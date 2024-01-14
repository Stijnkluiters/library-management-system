<?php

declare(strict_types=1);

namespace App\Domain\Stock\Infrastructure\Repositories;

use App\Domain\_shared\ID;
use App\Domain\Stock\Domain\Entities\Book;
use App\Models\Book as BookModel;

final readonly class BookRepository
{
    public function getBookById(ID $bookId): Book
    {
        $bookModel = BookModel::find($bookId);

        return new Book(
            new ID($bookModel->id),
            $bookModel->title,
            null
        );
    }
}
