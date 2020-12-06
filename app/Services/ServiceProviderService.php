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
    private $serviceProviderRepo, $firebaseService;

    public function __construct(ServiceProviderRepositories $serviceProviderRepo, FirebaseService $firebaseService)
    {
        $this->serviceProviderRepo = $serviceProviderRepo;
        $this->firebaseService = $firebaseService;
    }

    public function store($data)
    {
        $serviceProvider = $this->serviceProviderRepo->store($data);
        $this->uploadAvatar($data['avatar']);
        $this->uploadFiles($data['files']);
        $this->storeRealtimeDatabase($serviceProvider);
    }

    public function storeRealtimeDatabase($serviceProvider)
    {
        $data['name'] = $serviceProvider->id;
        $data['value'] = $serviceProvider;
        $this->firebaseService->store($data);
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
        $data = $this->serviceProviderRepo->update($data, $serviceProvider);

        $this->UpdateRealtimeDatabase($serviceProvider, $serviceProvider->id);
    }

    public function UpdateRealtimeDatabase($data, $node)
    {
        $this->firebaseService->update($data, $node);
    }

    public function delete($serviceProvider)
    {
        $this->serviceProviderRepo->delete($serviceProvider);
        $this->firebaseService->destroy($serviceProvider->id);
    }

    public function distance($data)
    {
        return $this->serviceProviderRepo->distance($data);
    }
    
}
