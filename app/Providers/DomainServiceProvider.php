<?php

namespace App\Providers;

use App\Domain\Orders\Application\Providers\OrderServiceProvider;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->app->resolveProvider(OrderServiceProvider::class);
    }
}
