<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Store extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function store_posts() { //1対多の「多」側なので複数形
        return $this->hasMany(StorePost::class);
    }
    public function items() {
        return $this->hasMany(Item::class);
    }
    public function store_orders() {
        return $this->hasMany(StoreOrder::class);
    }

    protected $fillable = [
        'name',
        'name_kana',
        'email',
        'post_address',
        'address',
        'phone_number',
        'password',
        'introduction',
        'profile_image',
        'image_path',
        'is_deleted',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
