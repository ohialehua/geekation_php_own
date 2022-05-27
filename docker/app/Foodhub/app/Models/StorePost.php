<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePost extends Model
{
    use HasFactory;

    public function store() {
        return $this->belongsTo(Store::class);
    }
    public function post_comments() {
        return $this->hasMany(PostComment::class);
    }
    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    protected $fillable = [
        'store_id',
        'post_image',
        'body',
    ];

    public function isFavoritedBy($user): bool {
        return Favorite::where('user_id', $user->id)->where('store_post_id', $this->id)->first() !==null;
    }
}
