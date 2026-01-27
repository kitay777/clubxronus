<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['name', 'image_path', 'description'];

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }
}

