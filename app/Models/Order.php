<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'items',
        'total_price'
    ];

    protected $casts = [
        'items' => 'array', // JSON → массив
    ];


}
