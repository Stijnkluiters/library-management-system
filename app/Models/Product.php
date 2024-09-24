<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read string $uuid
 * @property int $price
 * @property string $name
 */
class Product extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
}
