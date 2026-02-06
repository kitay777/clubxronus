<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;
    
protected $fillable = [
    'user_id',
    'name',
    'profile',
    'birthday',
    'height',
    'style',
    'area',
    'blood_type',
    'role',
    'image_path',
];
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
public function blogs()
{
    return $this->hasMany(\App\Models\Blog::class);
}


}
