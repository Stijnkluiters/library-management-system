<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = Book::factory(10)->create();

        /** @var Book $book */
        foreach ($books as $book) {
            Stock::factory()->createOne([
                'book_title' => $book->getTitle()
            ]);
        }
    }
}
