<?php

declare(strict_types=1);

namespace App\Domain\_shared\Exceptions;

use App\Domain\_shared\UUID;

class EntityNotFoundException extends DomainException
{
    public static function create(UUID $uuid): self
    {
        return new self("Cannot find entity: {$uuid}.");
    }
}
