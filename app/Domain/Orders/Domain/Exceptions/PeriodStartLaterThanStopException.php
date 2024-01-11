<?php

namespace App\Domain\Orders\Domain\Exceptions;

use App\Domain\_shared\Exceptions\DomainException;

class PeriodStartLaterThanStopException extends DomainException
{
    public static function create($start, $stop): self
    {
        return new self("The starttime: {$start->toDateTime()} is greater than the stoptime: {$stop->toDateTime()}");
    }
}
