<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

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
}
