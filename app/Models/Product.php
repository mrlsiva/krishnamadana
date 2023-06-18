<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function meta()
    {
        return $this->hasOne(ProductMeta::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function collection()
    {
        return $this->belongsToMany(Collection::class);
    }

    public function items()
    {
        return $this->hasMany(ProductItem::class);
    }
}
