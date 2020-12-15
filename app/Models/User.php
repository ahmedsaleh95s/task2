<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imagable');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function findForPassport($username)
    {
        return $this->where('email', $username)
            ->orWhere('phone', $username)->first();
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function fcms()
    {
        return $this->morphMany(FcmToken::class, 'tokenable');
    }

    public function routeNotificationForFcm()
    {
        return $this->fcms()->pluck('fcm_token')->toArray();
    }
}
