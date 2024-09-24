<?php

namespace App\Http\Controllers;

use App\Domain\Catalog\Domain\Services\CatalogService;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(
        private CatalogService $productService
    ) { }

    public function index(): View
    {
        $products = $this->productService->getAllProducts();

        return view('product.index', compact('products'));
    }
}
