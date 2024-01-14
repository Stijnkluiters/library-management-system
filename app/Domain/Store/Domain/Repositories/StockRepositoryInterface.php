<?php

namespace App\Domain\Store\Domain\Repositories;

use App\Domain\_shared\ID;
use App\Domain\Store\Domain\Entities\Book as BookEntity;

interface StockRepositoryInterface
{
    public function hasBook(ID $bookId): bool;
    public function getBook(ID $bookId): BookEntity;
}
