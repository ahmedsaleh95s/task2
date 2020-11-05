<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function getLinkAttribute($value)
    {
        return asset($value);
    }
}
