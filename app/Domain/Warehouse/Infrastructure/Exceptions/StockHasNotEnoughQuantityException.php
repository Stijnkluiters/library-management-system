<?php

namespace App\Domain\Stock\Infrastructure\Exceptions;

use App\Domain\_shared\Exceptions\DomainException;

class StockHasNotEnoughQuantityException extends DomainException
{
    /**
     * @throws StockHasNotEnoughQuantityException
     */
    public static function create(string $bookTitle): self
    {
        throw new self('Stock does not contain enough of: ' . $bookTitle);
    }
}
