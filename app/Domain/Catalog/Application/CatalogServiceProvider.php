<?php

declare(strict_types=1);

namespace App\Domain\Catalog\Application;

use App\Domain\Catalog\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Catalog\Infrastructure\Repository\ProductRepository;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    public function boot(): void
    {
    }
}
