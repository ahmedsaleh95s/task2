<?php

namespace App\Repositories;
use App\Models\User;
use App\Traits\ImageTrait;

class UserRepositories 
{
    use ImageTrait;
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function store($data)
    {
        $this->user = $this->user->create($data);
        if (!empty($data['photo'])) {
            $link['image'] = $this->uploadImage($data['photo'], "users");
            $this->saveImage($link);
        }
    }

    public function saveImage($link)
    {
        $this->user->image()->create($link);
    }

    public function resetPassword($data)
    {
        auth()->user()->update(['password' => $data['password']]);
        auth()->user()->tokens()->delete();
    }
}