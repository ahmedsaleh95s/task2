<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'file', 'filable_type', 'filable_id'
    ];

    public function filable()
    {
        return $this->morphTo();
    }

    public function getFileAttribute($value)
    {
        return Storage::url($value);
    }
}