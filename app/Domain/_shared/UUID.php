<?php

declare(strict_types=1);

namespace App\Domain\_shared;

use Stringable;
use Ramsey\Uuid\Uuid as _uuid;

final readonly class UUID implements Stringable
{
    public function __construct(
        private string $id
    ) {

    }

    public static function createFromString(string $id): self
    {
        return new self($id);
    }

    public static function new(): self
    {
        return new self(_uuid::uuid4()->toString());
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
