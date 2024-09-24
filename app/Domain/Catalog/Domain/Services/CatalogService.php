<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Domain\Services;

use App\Domain\Catalog\Domain\Entities\Product;
use App\Domain\Catalog\Domain\Repositories\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;

readonly class CatalogService
{
    public function __construct(
        private ProductRepositoryInterface $productRepositoryInterface
    ) { }

    /**
     * @return Product[]
     */
    public function getAllProducts(): array
    {
        return $this->productRepositoryInterface->getAll();
    }

    public function notifyProductOrderedSuccessful(): void
    {
        Log::channel('eventBus')->info('Product ordered successfully');
    }
}
