<?php

namespace App\Domain\Warehouse\Infrastructure\Services;

use App\Domain\_shared\ID;

final readonly class WarehouseService
{
    public function __construct(
    ) {
    }

    public function order(ID $bookId, int $amount): array
    {
        $bookIds = [];
        for ($i = 0; $i < $amount; $i++)
        {
            $bookIds[] = $bookId;
        }

        return $bookIds;
    }
}
