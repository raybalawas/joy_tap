<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // public function animalVideos()
    // {
    //     return $this->hasMany(AnimalVideo::class, 'scene_name');
    // }
}
