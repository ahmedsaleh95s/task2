<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\WorkingHoursResource;

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
            "working_hours" => WorkingHoursResource::collection($this->workingHours),
        ];
    }
}
