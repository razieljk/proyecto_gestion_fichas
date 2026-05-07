<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class, 'users_id');
    }

    public function aprendiz()
    {
        return $this->hasOne(Aprendiz::class, 'users_id');
    }

    public function esInstructor()
    {
        return $this->rol === 'instructor';
    }

    public function esAprendiz()
    {
        return $this->rol === 'aprendiz';
    }

    public function esAdmin()
    {
        return $this->rol === 'admin';
    }
}