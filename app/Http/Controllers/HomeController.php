<?php

namespace App\Http\Controllers;

use App\Domain\Catalog\Domain\Services\CatalogService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(
        private CatalogService $catalogService,
    ) {
    }

    public function index(): View
    {
        $products = $this->catalogService->getAllProducts();

        return view('welcome', compact('products'));
    }
}
