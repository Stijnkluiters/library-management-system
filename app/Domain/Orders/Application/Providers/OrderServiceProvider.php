<?php

declare(strict_types=1);

namespace App\Domain\Orders\Application\Providers;

use App\Domain\Orders\Infrastructure\Repository\OrderRepository;
use App\Domain\Orders\Domain\Repository\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function boot(): void
    {
    }
}
