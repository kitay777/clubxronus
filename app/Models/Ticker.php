<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    protected $fillable = [
        'text',
        'order',
        'is_active',
    ];
}

