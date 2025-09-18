<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['type','from_warehouse_id','to_warehouse_id','branch_id','status','user_id'];

    public function items() { return $this->hasMany(TransactionItem::class); }
    public function from_warehouse() { return $this->belongsTo(Warehouse::class, 'from_warehouse_id'); }
    public function to_warehouse() { return $this->belongsTo(Warehouse::class, 'to_warehouse_id'); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function user() { return $this->belongsTo(User::class); }
}
