<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function post_comments() {
        return $this->hasMany(PostComment::class);
    }

    protected $fillable = [
        'store_id',
        'post_image',
        'body',
    ];
}
