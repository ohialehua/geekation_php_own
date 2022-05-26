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

    protected $fillable = [
        'store_id',
        'post_image_id',
        'body',
    ];
}
