<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Infrastructure\Subscribers;
use App\Domain\Catalog\Domain\Services\CatalogService;
use App\Domain\Orders\Domain\Events\OrderLineAdded;

readonly class OrderSubscriber
{
    public function __construct(private CatalogService $catalogService) { }

    public function handleOrderLineAdded(OrderLineAdded $event): void
    {
        $this->catalogService->notifyProductOrderedSuccessful();
    }
}
