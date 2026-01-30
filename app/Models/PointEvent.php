<?php
// app/Models/PointEvent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class PointEvent extends Model
{
    protected $fillable = [
        'name',
        'start_at',
        'end_at',
        'rate',
        'is_active',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
        'is_active'=> 'boolean',
    ];

    /**
     * 現在有効なイベント
     */
    public function scopeActiveNow(Builder $q): Builder
    {
        return $q->where('is_active', true)
                 ->where('start_at', '<=', now())
                 ->where('end_at', '>=', now());
    }
}
