<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\ServiceProvider;
use App\Enums\ProviderType;

class ServiceProviderRepositories implements AuthInterface
{
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
        $data['location'] = ['type' => "Point", 'coordinates' => [$data['long'], $data['lat']]];
        foreach ($data['Area_polygon'] as $point) {
            $points[] = [$point[1], $point[0]];
        }
        $data['area'] = [
            'type' => "Polygon",
            'coordinates' =>  [$points]
        ];
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
        return $serviceProvider;
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
        return $this->serviceProvider
            ->where('area', 'geoIntersects', [
                '$geometry' => [
                    'type' => 'Point',
                    'coordinates' => 
                        [(double)$data['long'], (double)$data['lat']],
                ],
            ])->get();
    }

    public function workingHoursByColumn($serviceProvider, $column, $value)
    {
        return $serviceProvider->workingHours()->where($column, $value)->get();
    }

    public function workingHours($serviceProvider)
    {
        return $serviceProvider->workingHours()->get();
    }
}
