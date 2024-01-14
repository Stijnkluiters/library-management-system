<?php

declare(strict_types=1);

namespace App\Domain\Orders\Application\Providers;

use App\Domain\_shared\EventBus;
use App\Domain\Orders\Domain\Events\BookOrderedEvent;
use App\Domain\Stock\Infrastructure\Services\StockService;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
    }
}
