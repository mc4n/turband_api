<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'role',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['is_admin'];

    protected function getIsAdminAttribute()
    {
        return $this->role === 5;
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
}
