<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreNotification extends Model
{
    use HasFactory;

    public function store_post() {
        return $this->belongsTo(StorePost::class);
    }
    public function post_comment() {
        return $this->belongsTo(PostComment::class);
    }
    public function store() {
        return $this->belongsTo(Store::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function store_order() {
        return $this->belongsTo(StoreOrder::class);
    }

    protected $fillable = [
        'user_id',
        'store_id',
        'store_order_id',
        'post_comment_id',
        'action_id',
        'checked_id',
    ];
}
