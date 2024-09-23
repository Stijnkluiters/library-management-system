<?php

namespace App\Http\Controllers;

use App\Domain\_shared\UUID;
use App\Domain\Orders\Domain\Services\OrderService;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    public function index(): View
    {
        $orders = $this->orderService->getAllOrdersForUser(UUID::createFromString('7f708597-79e2-11ef-b26c-0242ac190002'));

        return view('order.index', compact('orders'));
    }

    public function show(string $orderId): View
    {
        $order = $this->orderService->getOrderById($orderId);

        return view('order.show', compact('order'));
    }
}
