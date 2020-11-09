<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceProvider extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_ar','name_en','phone','email'
    ];

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

    public function places()
    {
        return $this->hasMany(Place::class);
    }

    public function workingHours()
    {
        return $this->hasMany(WorkingHour::class);
    }
}
