<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    // الحقول اللي مسموح تعملها mass assignment
    protected $fillable = [
        'name',
        'description',
        'discount_value',
        'start_at',
        'end_at',
    ];

    // تحويل الحقول للتواريخ تلقائيًا
    protected $dates = [
        'start_at',
        'end_at',
        'created_at',
        'updated_at',
    ];

    // مثال: function لحساب قيمة الخصم على سعر محدد
    public function applyDiscount($originalPrice)
    {
        return $originalPrice - $this->discount_value;
    }

    // App\Models\Offers.php
public function products()
{
    return $this->belongsToMany(Product::class, 'offer_products', 'offer_id', 'product_id');
}



    // لو في المستقبل حبينا نضيف علاقة مع Product مثلا
    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }
}

