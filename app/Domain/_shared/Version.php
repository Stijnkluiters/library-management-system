<?php

namespace App\Domain\_shared;

readonly class Version
{
    public function __construct(
        private int $versionNumber,
    )
    {
    }

    public function getVersionNumber(): int
    {
        return $this->versionNumber;
    }
}
