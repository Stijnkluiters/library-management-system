<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Infrastructure\Repository;

use App\Domain\_shared\UUID;
use App\Domain\_shared\ValueObjects\Price;
use App\Domain\Catalog\Domain\Repositories\ProductRepositoryInterface;
use App\Models\Product as ProductModel;
use App\Domain\Catalog\Domain\Entities\Product as ProductEntity;

readonly class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @return ProductEntity[]
     */
    public function getAll(): array
    {
        return ProductModel::all()->map(function (ProductModel $product) {
            return $this->transformModelToDomain($product);
        })->toArray();
    }

    private function transformModelToDomain(ProductModel $product): ProductEntity
    {
        return new ProductEntity(
            UUID::createFromString($product->uuid),
            new Price($product->price),
            $product->name
        );
    }
}
