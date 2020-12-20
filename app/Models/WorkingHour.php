<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkingHour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'from',
        'to',
        'day',
        'service_provider_id',
        'allowed_time',
        'price'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
