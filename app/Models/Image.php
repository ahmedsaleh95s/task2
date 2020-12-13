<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'image', 'imagable_type', 'imagable_id'
    ];

    public function imagable()
    {
        return $this->morphTo();
    }

    public function getImageAttribute($value)
    {
        return Storage::url($value);
    }
}
