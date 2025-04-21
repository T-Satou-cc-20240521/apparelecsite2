<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'category_id',
        'description',
    ];

    protected $appends = [
        'category',
    ];

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}

