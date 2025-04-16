<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password_hash',
        'address',
        'email_verified_at',
        'is_active',
        'is_admin',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = bcrypt($value);
    }

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
