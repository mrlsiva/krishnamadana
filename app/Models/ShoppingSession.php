<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cart_id',
        'name',
        'price',
        'quantity',
        'attributes',
        'associated_model_id',
    ];
}
