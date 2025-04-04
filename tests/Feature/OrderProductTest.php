<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrderProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    public function test_can_create_order_of_product_when_logged_in(): void
    {
        $expectedUser = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(route('products.order', ['productId' => $product->uuid]));

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $expectedUser->uuid,
        ]);
        $this->assertDatabaseHas('order_lines', [
            'product_id' => $product->uuid,
            'amount' => 1,
            'price' => $product->price,
            'name' => $product->name,
        ]);
    }
}
