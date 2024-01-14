<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class OrderBookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function test_the_application_can_order_a_fake_book(): void
    {
        $bookTitle = 'my_amazing_book_title';
        $book = Book::factory()->create(['title' => $bookTitle]);
        $customerId = 1;

        /** @var Stock $stock */
        $stock = Stock::create([
            'book_title' => $bookTitle,
            'quantity' => 1,
        ]);
        $response = $this->post(route('books.order', $bookTitle), [
            'book_title' => $bookTitle,
            'customer_id' => $customerId,
            'start_at' => Carbon::now()->toDateTimeString(),
            'end_at' => Carbon::now()->addMonth()->toDateTimeString(),
        ]);

        $stock->refresh();
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('books', 1);
        $this->assertDatabaseHas('orders', [
            'customer_id' => $customerId,
            'price' => $book->price,
        ]);
        $this->assertSame(0, $stock->getQuantity());

        $response->assertStatus(302);
    }

    public function test_cannot_order_two_books_when_there_is_only_one_in_stock(): void
    {
        $bookTitle = 'my_amazing_book_title';
        $book = Book::factory()->create(['title' => $bookTitle]);
        $customerId = 1;

        /** @var Stock $stock */
        $stock = Stock::create([
            'book_title' => $bookTitle,
            'quantity' => 1,
        ]);
        $responseOne = $this->post(route('books.order', $bookTitle), [
            'book_title' => $bookTitle,
            'customer_id' => $customerId,
            'start_at' => Carbon::now()->toDateTimeString(),
            'end_at' => Carbon::now()->addMonth()->toDateTimeString(),
        ]);
        $stock->refresh();
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('books', 1);
        $this->assertDatabaseHas('orders', [
            'book_id' => 2,
            'customer_id' => $customerId,
            'price' => $book->price,
        ]);
        $this->assertSame(0, $stock->getQuantity());

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Stock does not contain enough of: '. $bookTitle);
        $this->post(route('books.order', $bookTitle), [
            'book_title' => $bookTitle,
            'customer_id' => $customerId,
            'start_at' => Carbon::now()->toDateTimeString(),
            'end_at' => Carbon::now()->addMonth()->toDateTimeString(),
        ]);
    }
}
