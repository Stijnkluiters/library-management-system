<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_title',
        'quantity'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_title', 'title');
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getBookTitle(): string
    {
        return $this->book_title;
    }

    public function reduceStock(): void
    {
        $this->quantity = $this->quantity - 1;
    }
}
