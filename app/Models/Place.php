<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use HasFactory, SoftDeletes, SpatialTrait;

    protected $fillable = [
        'service_provider_id','location','area'
    ];

    protected $spatialFields = [
        'location','area'
    ];
}
