<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'stock',
        'amount',
        'display_name',
    ];

    public function configurations()
    {
        return $this->hasMany(ProductConfiguration::class);
    }

    public function options()
    {
        return $this->hasManyThrough(
            VariationOption::class,
            ProductConfiguration::class,
            'product_item_id',
            'variation_id',
            'id',
            'variation_option_id',
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
