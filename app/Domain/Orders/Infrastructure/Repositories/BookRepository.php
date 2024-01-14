<?php

declare(strict_types=1);

namespace App\Domain\Orders\Infrastructure\Repositories;

use App\Domain\_shared\ID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\Orders\Domain\Entities\Book;

final readonly class BookRepository
{
    public function getBookByTitle($title): Book
    {
        /** @var \App\Models\Book $bookModel */
        $bookModel = \App\Models\Book::where('title', $title)->firstOrFail();

        return new Book(
            new ID($bookModel->id),
            $bookModel->getTitle(),
            Price::makeFromPrice($bookModel->getPrice()),
        );
    }

    public function getBookById(ID $ID): Book
    {
        /** @var \App\Models\Book $bookModel */
        $bookModel = \App\Models\Book::findOrFail($ID->getId());

        return new Book(
            $ID,
            $bookModel->getTitle(),
            Price::makeFromPrice($bookModel->getPrice())
        );
    }
}
