<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function meta()
    {
        return $this->hasOne(ProductMeta::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function attributeSku()
    {
        return $this->hasMany(AttributeSku::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function collection()
    {
        return $this->belongsToMany(Collection::class);
    }
}
