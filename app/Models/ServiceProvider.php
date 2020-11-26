<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Carbon\Carbon;

class ServiceProvider extends Authenticatable
{
    use HasFactory, SoftDeletes, SpatialTrait, HasApiTokens;

    protected $with = ['workingHours','categories'];
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

    public function getIntervals()
    {
        $intervals = [];
        $index = 0;
        foreach ($this->workingHours as $workingHour) {
            $start = $workingHour->from;
            while ($start < $workingHour->to && Carbon::parse($workingHour->to)->diffInMinutes(Carbon::parse($start)) >= $this->allowed_time) {
                $intervals[$index]['day'] =  Carbon::create($workingHour->day)->locale('en_US')->dayName;
                $intervals[$index]['from'] = $from = $start;
                $intervals[$index]['to'] = $start =
                    Carbon::parse($start)
                    ->addMinutes($this->allowed_time)
                    ->format('h:i A');
                $reserved = +$this->getReserved($workingHour->reservations, $intervals[$index]);
                $intervals[$index]['reserved'] = ($reserved) ? ReservationStatus::RESERVED : ReservationStatus::NOT_RESERVED;
                $index++;
            }
        }
        return $intervals;
    }

    public function getReserved($reservations, $interval)
    {
        return $reservations->contains(function ($value, $key) use($interval){
            $dateFrom = Carbon::parse($value->from);
            $dateTo = Carbon::parse($value->to); // check range not equal
            return (string)$dateFrom->dayOfWeek == $interval['day'] && $dateFrom->format('h:i A') >= $interval['from'] && $dateTo->format('h:i A') <= $interval['to'];
        });
    }
}
