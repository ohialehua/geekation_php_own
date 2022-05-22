<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreOrder extends Model
{
    use HasFactory;

    public function order_items() {
        return $this->hasMany(OrderItem::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function item() {
        return $this->belongsTo(Item::class);
    }
    public function order() {
        return $this->belongsTo(Order::class);
    }

    protected $fillable = [
        'user_id',
        'store_id',
        'order_id',
        'order_status',
    ];
}
