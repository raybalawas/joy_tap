<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Models\BlockedUsers;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        // 'brand_name',
        'phone',
        'dob',
        'class',
        'language',
        // 'user_type',
        // 'password',
        // 'profile_image',
        // 'vertical_id',
    ];

    // protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getProfileImageAttribute()
    {
        $profileImage = $this->attributes['profile_image'];
        $path = public_path('admin-assets/uploads/profileimages/' . $profileImage);

        if (file_exists($path) && $profileImage) {
            return asset('admin-assets/uploads/profileimages/' . $profileImage);
        }
        return asset('admin-assets/uploads/profileimages/' . 'placeholder.png');
    }


    // public function languages()
    // {
    //     return $this->belongsTo(Language::class, 'language');
    // }

    public function languages()
    {
        return $this->belongsTo(Language::class, 'language');
    }
}
