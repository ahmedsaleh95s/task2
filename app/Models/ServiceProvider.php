<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;

class ServiceProvider extends Authenticatable
{
    use HasFactory, SoftDeletes, SpatialTrait, HasApiTokens;

    protected $fillable = [
        'name_ar','name_en','phone','email','area','location','password','price','allowed_time'
    ];

    protected $spatialFields = [
        'location','area'
    ];

    protected $hidden = [
        'password',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imagable');
    }

    public function files()
    {
        return $this->morphMany(File::class, 'filable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }
}
