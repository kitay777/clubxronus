<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    protected $fillable = [
        'name',
        'shimei',  // 氏名  ★ 追加
        'email',
        'is_approved',  // 承認済みかどうか  ★ 追加
        'tel',  // 電話番号
        'password',
        'point',  // ポイント
        'profile_photo_path',  // プロフィール写真
        'is_cast',  // キャストかどうか
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
        'password' => 'hashed',
    ];

    public function cast()
    {
        return $this->hasOne(\App\Models\Cast::class);
    }
    public function pointHistories()
    {
        return $this->hasMany(\App\Models\PointHistory::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(\App\Models\Coupon::class, 'coupon_user')
            ->withPivot(['acquired_at', 'used_at'])
            ->withTimestamps();
    }
        public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function visits()
    {
        return $this->hasMany(UserVisit::class);
    }

}
