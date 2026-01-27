<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['shop_id', 'title', 'image_path', 'description', 'valid_until'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'coupon_user')
            ->withPivot(['acquired_at', 'used_at'])
            ->withTimestamps();
    }

}

