<?php
// app/Models/PointBaseSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointBaseSetting extends Model
{
    protected $fillable = [
        'rate',
    ];

    /**
     * 常に1件前提なのでショートカット
     */
    public static function current(): self
    {
        return static::firstOrFail();
    }
}
