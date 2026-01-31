<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',     // ← ★これを追加
        'nickname',
        'age',
        'blood_type',
        'birthday',
        'residence',
        'referrer',
        'features',
        'memo',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
