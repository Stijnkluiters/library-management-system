<?php

namespace App\Domain\Catalog\Domain\Repositories;

use App\Domain\_shared\UUID;
use App\Domain\Catalog\Domain\Entities\Product;

interface ProductRepositoryInterface
{
    /**
     *  @return \App\Domain\Catalog\Domain\Entities\Product[]
     */
    public function getAll();

    /**
     * @param \App\Domain\_shared\UUID $uuid
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @return Product
     */
    public function find(UUID $uuid): Product;
}
