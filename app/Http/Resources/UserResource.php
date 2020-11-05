<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ImageResource;
use App\Http\Resources\TokenResource;

class UserResource extends JsonResource
{
    private $token;

    public function __construct($resource, $token=null) {
        parent::__construct($resource);
        $this->resource = $resource;
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            'token' => new TokenResource(json_decode($this->token)),
            "image" => ImageResource::collection($this->images)
        ];
    }
}
