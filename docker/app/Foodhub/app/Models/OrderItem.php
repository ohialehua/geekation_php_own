<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    public function order() {
        return $this->belongsTo(Order::class);
    }
    public function store_order() {
        return $this->belongsTo(StoreOrder::class);
    }
    public function item() {
        return $this->belongsTo(Item::class);
    }

    protected $fillable = [
        'order_id',
        'store_order_id',
        'item_id',
        'quantity',
        'price_after_tax',
        'product_status',
    ];
}
