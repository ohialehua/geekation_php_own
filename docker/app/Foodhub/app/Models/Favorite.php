<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public function user_post() {
        return $this->belongsTo(UserPost::class);
    }
    public function store_post() {
        return $this->belongsTo(StorePost::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'user_post_id',
        'store_post_id',
    ];
}
