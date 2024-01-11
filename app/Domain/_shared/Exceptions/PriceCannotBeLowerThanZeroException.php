<?php

namespace App\Domain\_shared\Exceptions;

use App\Domain\_shared\ValueObjects\Price;

class PriceCannotBeLowerThanZeroException extends \DomainException
{
    public static function create(Price $price): self
    {
        return new self("The price cannot be lower than 0: {$price->getPrice()}.");
    }
}
