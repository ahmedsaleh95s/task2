<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\WorkingHoursResource;
use Carbon\Carbon;

class ServiceProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            "id" => $this->id,
            "name_ar" => $this->name_ar,
            "name_en" => $this->name_en,
            "phone" => $this->phone,
            "email" => $this->email,
            "location" => $this->location,
            "area" => $this->area,
            'price' => $this->price,
            'allowed_time' => $this->allowed_time,
            "categories" => CategoryResource::collection($this->categories),
            "working_hours" => IntervalResource::collection($this->getIntervals($this->workingHours, $this->allowed_time)),
        ];
    }

    public function getIntervals($workingHours, $allowed_time)
    {
        $index = 0;
        foreach ($workingHours as $workingHour) {
            $start = $workingHour->from;
            while ($start < $workingHour->to) {
                $intervals[$index]['day'] = $workingHour->day;
                $intervals[$index]['from'] = $start;
                $intervals[$index]['to'] = $start =
                    Carbon::parse($start)
                    ->addMinutes($allowed_time)
                    ->format('h:i A');
                $index++;
            }
        }
        return $intervals;
    }
}
