<?php

namespace App\Http\Controllers;

use App\Domain\_shared\UUID;
use App\Domain\Orders\Domain\Services\OrderService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * @param \App\Domain\Orders\Domain\Services\OrderService $orderService
     */
    public function __construct(
        private readonly OrderService $orderService,
    ) {
    }

    /**
     * @param string $productId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function order(string $productId): RedirectResponse
    {
        $uuid = UUID::createFromString($productId);

        $order = $this->orderService->orderProduct($uuid, 1);

        return redirect()
            ->route('orders.show', $order->getUuid())
            ->with('success', 'Your product has successfully been ordered');
    }

    /**
     * @param string $orderId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(string $orderId): View
    {
        $order = $this->orderService->getOrderById($orderId);

        return view('order.show', compact('order'));
    }
}
