<?php

namespace App\Http\Controllers;

use App\Domain\Catalog\Infrastructure\Services\ShoppingCartService;
use App\Domain\Orders\Domain\Services\OrderService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * @param \App\Domain\Orders\Domain\Services\OrderService $orderService
     * @param \App\Domain\Catalog\Infrastructure\Services\ShoppingCartService $shoppingCartService
     */
    public function __construct(
        private readonly OrderService $orderService,
        private readonly ShoppingCartService $shoppingCartService,
    ) {
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function order(): RedirectResponse
    {
        $shoppingCartItems = $this->shoppingCartService->popAllShoppingCartItems();

        if ($shoppingCartItems === null) {
            return redirect()
                ->route('home.index')
                ->with('Error', 'There was nothing in your shopping cart.');
        }

        $order = $this->orderService->orderByShoppingCartItems($shoppingCartItems);

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
