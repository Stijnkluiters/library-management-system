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
        $bookModel = \App\Models\Book::where('title', $title)->firstOrFail();
        return new Book(
            new ID($bookModel->id),
            Price::makeFromPrice($bookModel->price),
        );
    }
}
