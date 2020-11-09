<?php

namespace App\Repositories;

use App\Models\ServiceProvider;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;

class ServiceProviderRepositories
{
    public $serviceProvider;

    public function __construct(ServiceProvider $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
    }

    public function store($data)
    {
        $this->serviceProvider = $this->serviceProvider->create($data);
        $this->serviceProvider->categories()->attach($data['Categories']);
        $this->serviceProvider->workingHours()->createMany($data['working_hours']);
        $points = $this->handlePlaces($data);
        $this->serviceProvider->places()->create($points);
    }

    public function saveAvatar($link)
    {
        $this->serviceProvider->image()->create(['image' => $link]);
    }

    public function saveFiles($links)
    {
        $this->serviceProvider->files()->createMany($links);
    }

    public function handlePlaces($data)
    {
        $place['location'] = new Point($data['lat'], $data['long']);
        foreach ($data['Area_polygon'] as $point) {
            $points[] = new Point($point[0], $point[1]);
        }
        $place['area'] = new Polygon([new LineString($points)]);
        return $place;
    }
}
