<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/PointSetting.php
class PointSetting extends Model
{
    protected $fillable = [
        'base_rate',
        'event_bonus_rate',
        'event_start_time',
        'event_end_time',
        'event_enabled',
    ];
}

