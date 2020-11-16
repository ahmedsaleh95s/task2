<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\ServiceProvider;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use App\Enums\ProviderType;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class ServiceProviderRepositories implements AuthInterface
{
    use SpatialTrait;
    public $serviceProvider;

    public function __construct(ServiceProvider $serviceProvider)
    {
        $this->serviceProvider = $serviceProvider;
    }

    public function store($data)
    {
        $data = $this->handlePlaces($data);
        $this->serviceProvider = $this->serviceProvider->create($data);
        $this->serviceProvider->categories()->attach($data['Categories']);
        $this->serviceProvider->workingHours()->createMany($data['working_hours']);
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
        $data['location'] = new Point($data['lat'], $data['long']);
        foreach ($data['Area_polygon'] as $point) {
            $points[] = new Point($point[0], $point[1]);
        }
        $data['area'] = new Polygon([new LineString($points)]);
        return $data;
    }

    public function all()
    {
        return $this->serviceProvider->all();
    }

    public function show($id)
    {
        return $this->serviceProvider->find($id);
    }

    public function update($data, $serviceProvider)
    {
        $data = $this->handlePlaces($data);
        $serviceProvider->update($data);
        $serviceProvider->categories()->sync($data['Categories']);
        $serviceProvider->workingHours()->delete(); // sync
        $serviceProvider->workingHours()->createMany($data['working_hours']);
    }

    public function delete($serviceProvider)
    {
        $serviceProvider->categories()->delete();
        $serviceProvider->workingHours()->delete();
        $serviceProvider->delete();
    }

    public function getModel($username)
    {
        return $this->serviceProvider->where('email', $username)->first();
    }

    public function getProvider()
    {
        return ProviderType::SERVICE_PROVIDER;
    }

    public function distance($data)
    {
        $geometry = new Point($data['lat'], $data['long']);
        return $this->serviceProvider
        ->contains('area', $geometry)
        ->orderByDistance('area',$geometry)
        ->get();
    }
}
