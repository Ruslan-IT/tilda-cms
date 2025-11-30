<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'old_price',
        'sku',
        'short_description',
        'full_description',
        'image',
    ];
}
