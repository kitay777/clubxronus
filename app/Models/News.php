<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'cast_id',
        'user_id',
        'title',
        'body',
        'image_path',
        'published_at',
        'is_all',
    ];
    public function cast() { return $this->belongsTo(\App\Models\Cast::class); }
    public function user() { return $this->belongsTo(\App\Models\User::class); }
    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
