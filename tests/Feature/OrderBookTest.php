<?php

namespace Tests\Feature;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderBookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_can_order_a_fake_book(): void
    {
        $bookTitle = 'my_amazing_book_title';
        $book = Book::factory()->create(['title' => $bookTitle]);
        $customerId = 1;

        $response = $this->post('/order', [
            'book_title' => $bookTitle,
            'customer_id' => $customerId,
            'start_at' => Carbon::now()->toDateTimeString(),
            'end_at' => Carbon::now()->addMonth()->toDateTimeString(),
        ]);


        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('books', 1);

        $this->assertDatabaseHas('orders', [
            'book_id' => 1,
            'customer_id' => $customerId,
            'price' => $book->price,
        ]);

        $response->assertStatus(200);
    }
}
