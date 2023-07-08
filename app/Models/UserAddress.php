<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mobile',
        'address_line1',
        'address_line2',
        'landmark',
        'city',
        'state_id',
        'is_default',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
