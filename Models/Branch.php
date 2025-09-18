<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'phone'];

    // علاقة مع Warehouse
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
