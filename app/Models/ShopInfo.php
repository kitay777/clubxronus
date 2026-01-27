<?php

// app/Models/ShopInfo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopInfo extends Model
{
    use HasFactory;
    protected $table = 'shop_info'; // テーブル名を指定

    protected $fillable = [
        'address',
        'nearest_station',
        'phone',
    ];
}

