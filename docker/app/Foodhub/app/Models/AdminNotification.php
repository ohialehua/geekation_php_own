<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    public function store() {
        return $this->belongsTo(Store::class);
    }
    public function admin() {
        return $this->belongsTo(Admin::class);
    }

    protected $fillable = [
        'admin_id',
        'store_id',
        'checked_id',
    ];
}
