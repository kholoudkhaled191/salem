<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // if using auth

class Admin extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'type'];
    protected $hidden = ['password'];
}