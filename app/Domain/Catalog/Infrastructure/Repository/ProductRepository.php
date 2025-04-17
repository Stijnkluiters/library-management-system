<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Infrastructure\Repository;

use App\Domain\_shared\Exceptions\EntityNotFoundException;
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

    /**
     * @throws \App\Domain\_shared\Exceptions\EntityNotFoundException
     */
    public function find(UUID $uuid): ProductEntity
    {
        /** @var ProductModel|null $productModel */
        $productModel = ProductModel::query()->where('uuid', $uuid)->first();

        if ($productModel === null) {
            throw EntityNotFoundException::create($uuid);
        }

        return $this->transformModelToDomain($productModel);
    }

    /**
     * @param \App\Models\Product $product
     *
     * @return \App\Domain\Catalog\Domain\Entities\Product
     */
    private function transformModelToDomain(ProductModel $product): ProductEntity
    {
        return new ProductEntity(
            UUID::createFromString($product->uuid),
            new Price($product->price),
            $product->name,
            $product->image,
        );
    }
}
