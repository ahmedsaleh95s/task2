<?php

namespace App\Services;

use App\Repositories\ServiceProviderRepositories;
use App\Traits\FileTrait;
// use ImageOptimizer;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ServiceProviderService
{

    use FileTrait;
    private $serviceProviderRepo;

    public function __construct(ServiceProviderRepositories $serviceProviderRepo)
    {
        $this->serviceProviderRepo = $serviceProviderRepo;
    }

    public function store($data)
    {
        $this->serviceProviderRepo->store($data);
        $this->uploadAvatar($data['avatar']);
        $this->uploadFiles($data['files']);
    }

    public function uploadAvatar($image)
    {
        if (!empty($image)) {
            $link = $this->uploadFile($image, "serviceProviders");
            $path = Storage::path($link);
            ImageOptimizer::optimize($path);
            $this->saveAvatar($link);
        }
    }

    public function uploadFiles($files)
    {
        if (!empty($files)) {
            foreach ($files as $file) {
                $links[]['file'] = $this->uploadFile($file, "serviceProviders");
            }
            $this->saveFiles($links);
        }
    }

    public function saveAvatar($link)
    {
        $this->serviceProviderRepo->saveAvatar($link);
    }

    public function saveFiles($file)
    {
        $this->serviceProviderRepo->saveFiles($file);
    }

    public function all()
    {
        return $this->serviceProviderRepo->all();
    }

    public function show($id)
    {
        return $this->serviceProviderRepo->show($id);
    }

    public function update($data, $serviceProvider)
    {
        $this->serviceProviderRepo->update($data, $serviceProvider);
    }

    public function delete($serviceProvider)
    {
        $this->serviceProviderRepo->delete($serviceProvider);
    }

    public function distance($data)
    {
        return $this->serviceProviderRepo->distance($data);
    }
    
}
