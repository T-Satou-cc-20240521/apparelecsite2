<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $table = 'product_colors';
    protected $fillable = ['name', 'code'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
