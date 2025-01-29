<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmTokens extends Model
{
    use HasFactory;
    protected $table = "fcm_tokens";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
