<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Mutator لتشفير الباسورد تلقائياً
    
public function setPasswordAttribute($value)
{
    $this->attributes['password'] = \Illuminate\Support\Facades\Hash::make($value);
}
}
