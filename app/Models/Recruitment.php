<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $fillable = [
        'category', 'job_type', 'content', 'time', 'salary', 'benefit'
    ];
}

