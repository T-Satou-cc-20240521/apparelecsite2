<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

