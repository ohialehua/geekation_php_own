<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function user_posts() {
        return $this->hasMany(UserPost::class);
    }
    public function post_comments() {
        return $this->hasMany(PostComment::class);
    }
    public function deliveries() {
        return $this->hasMany(Delivery::class);
    }
    public function cart_items() {
        return $this->hasMany(CartItem::class);
    }
    public function store_orders() {
        return $this->hasMany(StoreOrder::class);
    }
    public function orders() {
        return $this->hasMany(Order::class);
    }
    public function markers() {
        return $this->hasMany(Marker::class);
    }

    protected $fillable = [
        'name',
        'introduction',
        'profile_image',
        'email',
        'full_name',
        'full_name_kana',
        'phone_number',
        'password',
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
