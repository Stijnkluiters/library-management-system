<?php

namespace App\Domain\Catalog\Infrastructure\Services;

use App\Domain\_shared\UUID;
use App\Domain\Catalog\Application\ShoppingCartItems;
use App\Domain\Catalog\Domain\Services\CatalogService;
use Illuminate\Contracts\Session\Session as SessionContract;

readonly class ShoppingCartService
{
    private string $productShoppingCartKey;

    /**
     * @param \Illuminate\Contracts\Session\Session $session
     * @param \App\Domain\Catalog\Domain\Services\CatalogService $catalogService
     */
    public function __construct(
        private SessionContract $session,
        private CatalogService $catalogService
    )
    {
        $this->productShoppingCartKey = 'shopping_cart_product';
    }

    /**
     * @param \App\Domain\_shared\UUID $uuid
     *
     * @return void
     */
    public function addToShoppingCart(UUID $uuid): void
    {
        // does the product exist?
        $product = $this->catalogService->findProduct($uuid);

        /** @var \App\Domain\Catalog\Application\ShoppingCartItems $shoppingCartItems */
        $shoppingCartItems = $this->session->get($this->productShoppingCartKey);

        if ($shoppingCartItems === null) {
            $shoppingCartItems = collect();
        }

        // (over)write amount with uuid
        $shoppingCartItems->put($product->getUuid(), 1);

        $this->session->put($this->productShoppingCartKey, $shoppingCartItems);
    }

    /**
     * @return \App\Domain\Catalog\Application\ShoppingCartItems|null
     */
    public function getShoppingCartItems(): ShoppingCartItems|null
    {
        /** @var \App\Domain\Catalog\Application\ShoppingCartItems $shoppingCartItems */
        $shoppingCartItems = $this->session->get($this->productShoppingCartKey);

        if ($shoppingCartItems === null) {
            return null;
        }

        return ShoppingCartItems::make(
            $shoppingCartItems->map(function (int $amount, string $uuidString) {
                return $this->catalogService->findProduct(UUID::createFromString($uuidString));
            })
        );
    }

    /**
     * @return \App\Domain\Catalog\Application\ShoppingCartItems|null
     */
    public function popAllShoppingCartItems(): ShoppingCartItems|null
    {
        $shoppingCartItems = $this->getShoppingCartItems();

        $this->session->remove($this->productShoppingCartKey);

        return $shoppingCartItems;
    }
}
