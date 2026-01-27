<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;
    
protected $fillable = [
    'name',
    'role',
    'profile',
    'image_path',
    'birthday',
    'height',
    'style',
    'area',
    'blood_type',
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
