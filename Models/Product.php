<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

 
    protected $fillable = [
        'name',
        'type',
        'colors',
        'images',
        'description',
        'price_before',
        'price_after',
    ];

    // ✅ عشان ترجع البيانات بشكل Array/Float جاهز
    protected $casts = [
        'colors' => 'array',
        'images' => 'array',
        'price_before' => 'float',
        'price_after' => 'float',
    ];

    // 🔹 علاقة: المنتج ليه مخزون واحد أو أكثر
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // 🔹 علاقة: المنتج ليه عرض/عروض (Many-to-Many)
    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_products', 'product_id', 'offer_id');
    }

    // 🔹 علاقة: المنتج ليه عناصر معاملات (Transaction Items)
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    // 🔹 علاقة: توصل للفروع من خلال الـ Warehouses
    public function branches()
    {
        return $this->hasManyThrough(
            Branch::class,      // الجدول النهائي (الفروع)
            Warehouse::class,   // الجدول الوسيط (المستودعات)
            'id',               // المفتاح الأساسي في warehouses
            'id',               // المفتاح الأساسي في branches
            'id',               // المفتاح الأساسي في products
            'branch_id'         // المفتاح الأجنبي في warehouses → branch_id
        );
    }
}
