<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'price',
        'customer_id',
        'book_id',
        'start_at',
        'end_at',
        'returned_at'
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
        'returned_at' => 'date'
    ];

    public function getPrice(): int
    {
        return $this->price;
    }

    public function customer(): BelongsTo
    {
        throw new \Exception('not implemented yet');
    }

    public function getStartAt(): Carbon
    {
        return $this->start_at;
    }

    public function getEndAt(): Carbon
    {
        return $this->end_at;
    }

    public function getReturnedAt(): ?Carbon
    {
        return $this->returned_at;
    }

    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_id','uuid');
    }
}
