<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'scene_name',
        'animal_type',
        'video_link',
        'language',
        'scene_audio',
        'ln_audio'
    ];

    public function sceneAudio()
    {
        return $this->belongsTo(SceneAudio::class, 'scene_audio', 'id');
    }


    public function scene()
    {
        return $this->belongsTo(Scene::class, 'scene_name');
    }

    public function languages()
    {
        return $this->belongsTo(Language::class, 'language');
    }

}