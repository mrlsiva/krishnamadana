<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeSku extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'sku_id',
        'value'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
}
