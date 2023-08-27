<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_id',
        'payment_id',
        'amount',
        'discount',
        'payment_status',
        'notes',
        'user_address_id',
    ];

    public function shipping_address()
    {
        return $this->hasOne(UserAddress::class, 'id', 'user_address_id')->withTrashed();
    }

    public function order_items()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id')->withTrashed();
    }
}
