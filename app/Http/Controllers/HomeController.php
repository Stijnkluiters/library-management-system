<?php

namespace App\Http\Controllers;

use App\Domain\_shared\UUID;
use App\Domain\Catalog\Domain\Services\CatalogService;
use App\Domain\Catalog\Infrastructure\Services\ShoppingCartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly ShoppingCartService $shoppingCartService,
    ) {
    }

    public function index(): View
    {
        $products = $this->catalogService->getAllProducts();
        $shoppingCartItems = $this->shoppingCartService->getShoppingCartItems();

        return view('welcome', compact('products', 'shoppingCartItems'));
    }

    public function addToCart(string $productId): RedirectResponse
    {
        $this->shoppingCartService->addToShoppingCart(UUID::createFromString($productId));

        return back()->with('success', 'Product added to cart successfully!');
    }
}
