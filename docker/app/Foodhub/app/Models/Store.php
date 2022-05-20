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
    public function posts() { //1対多の「多」側なので複数形
        return $this->hasMany('App\Models\Post');
    }
    public function items() {
        return $this->hasMany(Item::class);
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