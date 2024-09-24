<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read string $uuid
 * @property int $version
 * @property string $user_id
 */
class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'uuid',
        'user_id',
        'version'
    ];

    public function orderLines(): HasMany
    {
        return $this->hasMany(OrderLine::class, 'order_id','uuid');
    }
}
