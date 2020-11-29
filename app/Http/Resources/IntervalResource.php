<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IntervalResource extends JsonResource
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
            "day" => $this['day'],
            "dayNumber" => $this['dayNumber'],
            "from" => $this['from'],
            "to" => $this['to'],
            "reserved" => $this['reserved']
        ];
    }
}
