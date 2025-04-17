<?php

namespace App\Domain\Catalog\Domain\Repositories;

interface ProductRepositoryInterface
{
    /**
     *  @return \App\Domain\Catalog\Domain\Entities\Product[]
     */
    public function getAll();
}
