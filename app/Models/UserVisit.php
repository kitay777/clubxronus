<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVisit extends Model
{
    protected $fillable = [
        'user_id',      // ← ★これを必ず追加
        'visit_date',
        'amount',
        'cast_name',
        'time_slot',
        'memo',
    ];
}
