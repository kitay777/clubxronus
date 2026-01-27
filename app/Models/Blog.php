<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image_path',
        'body',
        'published_at',
        'cast_id',
    ];

    public function cast()
    {
        return $this->belongsTo(\App\Models\Cast::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
