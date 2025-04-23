<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'stock_quantity',
        'image_path',
        'is_active',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function product_color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }

    public function product_size()
    {
        return $this->belongsTo(ProductSize::class, 'size_id');
    }
}


