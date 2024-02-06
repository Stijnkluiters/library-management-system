<?php

namespace App\Domain\Store\Infrastructure\Exceptions;

use Exception;

class BookAlreadyExistException extends Exception
{
    public static function fromTitle(mixed $title): self
    {
        return new self('The book ' . $title . ' already exists!');
    }
}
