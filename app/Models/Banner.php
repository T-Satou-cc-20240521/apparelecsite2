<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'image_path',
        'link',
        'position',
        'priority',
        'start_at',
        'end_at',
        'is_active',
    ];

    protected $dates = [
        'start_at',
        'end_at',
        'created_at',
        'updated_at',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1)
                     ->where('start_at', '<=', now())
                     ->where('end_at', '>=', now());
    }
}
