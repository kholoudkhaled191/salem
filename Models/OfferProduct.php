<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'offer_id',
    ];

    // علاقة بالـ Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // علاقة بالـ Offer
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
