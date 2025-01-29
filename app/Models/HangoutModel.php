<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HangoutModel extends Model
{
    use HasFactory;
    protected $table='hangouts';
    protected $guarded = [];
}
