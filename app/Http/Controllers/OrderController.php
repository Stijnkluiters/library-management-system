<?php

namespace App\Http\Controllers;

use App\Domain\Store\Infrastructure\Services\OrderService;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService,
    ) {
    }

    public function index(): View
    {
        $orders = $this->orderService->getOrders(false);

        return view('orders.index', compact('orders'));
    }
}
