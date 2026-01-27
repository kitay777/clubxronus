<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUser extends Model
{
    use HasFactory;
    protected $table = 'coupon_user'; // テーブル名を指定

    protected $fillable = [
        'user_id',
        'coupon_id',
        'issued_at',  // クーポンが配布された日時
    ];

    /**
     * ユーザーとのリレーション
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * クーポンとのリレーション
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}


