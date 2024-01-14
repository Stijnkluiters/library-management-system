<?php

namespace App\Domain\_shared;

use Stringable;

final readonly class ID implements Stringable
{
    public function __construct(
        private int $id
    ) {
    }

    public static function createFromInt(int $id): self
    {
        return new self($id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }
}
