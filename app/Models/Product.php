<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property int $price
 * @property string $name
 * @property string|null $image
 */
class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
}
