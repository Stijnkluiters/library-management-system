<?php

namespace App\Domain\_shared;

use Stringable;

final readonly class ID implements Stringable
{
    public function __construct(
        private int $id
    ) {
    }

    public static function createFromInt(int $customerId): self
    {
        return new self($customerId);
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
