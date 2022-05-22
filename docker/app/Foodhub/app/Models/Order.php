<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function store_orders() {
        return $this->hasMany(StoreOrder::class);
    }
    public function order_items() {
        return $this->hasMany(OrderItem::class);
    }

    protected $fillable = [
        'user_id',
        'postage',
        'total_price',
        'pay_method',
        'post_address',
        'address',
        'name',
    ];
}
