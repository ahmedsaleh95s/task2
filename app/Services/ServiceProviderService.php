<?php

namespace App\Services;

use App\Repositories\ServiceProviderRepositories;
use App\Traits\ImageTrait;
use App\Traits\FileTrait;

class ServiceProviderService
{

    use ImageTrait, FileTrait;
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
            $link = $this->uploadImage($image, "serviceProviders");
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
    
}
