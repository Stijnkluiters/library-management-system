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

    /**
     * @var \App\Models\User
     */
    private User $user;

    /**
     * @var \App\Models\Product
     */
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->product = Product::factory()->create();
    }

    /**
     * @return void
     */
    public function test_can_create_order_of_product_when_logged_in(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson(route('products.order', ['productId' => $this->product->uuid]));

        $response->assertRedirect();

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->uuid,
        ]);
        $this->assertDatabaseHas('order_lines', [
            'product_id' => $this->product->uuid,
            'amount' => 1,
            'price' => $this->product->price,
            'name' => $this->product->name,
        ]);
    }

    /**
     * @return void
     */
    public function test_should_fail_when_create_order_with_non_existing_product(): void
    {
        $this->withExceptionHandling();
        $response = $this->postJson(route('products.order', ['productId' => 'what?']));
        $response->assertNotFound();
    }
}
