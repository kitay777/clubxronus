<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    protected $fillable = [
        'change',
        'reason',
        'balance',
        'user_id',
        // 必要に応じて他のカラムも
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

