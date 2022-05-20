<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function store() { //1対多の「１」側なので単数系
        return $this->belongsTo(Store::class);
    }

    protected $fillable = [
        'store_id',
        'image',
        'name',
        'body',
        'price_before_tax',
        'sales_figures',
        'is_active',
    ];
}
