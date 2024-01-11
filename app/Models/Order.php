<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'customer_id',
        'book_id',
        'start_at',
        'end_at'
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date'
    ];
}
