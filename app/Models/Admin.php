<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


class Admin extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes, HasFactory, HasRoles;

    protected $fillable = [
        'email', 'password', 'commission', 'role_id'
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function fcms()
    {
        return $this->morphMany(FcmToken::class, 'tokenable');
    }
}
