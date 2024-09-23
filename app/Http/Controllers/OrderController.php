<?php

namespace App\Http\Controllers;

use App\Domain\Store\Domain\Services\OrderService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    public function index(): View
    {
        $orders = $this->orderService->getOrders();

        return view('orders.index', compact('orders'));
    }
}
