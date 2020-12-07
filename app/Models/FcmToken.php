<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'fcm_token', 'tokenable_type', 'tokenable_id'
    ];

    public function tokenable()
    {
        return $this->morphTo();
    }
}
