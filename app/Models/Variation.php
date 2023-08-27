<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function options()
    {
        return $this->hasMany(VariationOption::class);
    }
}
