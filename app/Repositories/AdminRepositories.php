<?php

namespace App\Repositories;

use App\Enums\ProviderType;
use App\Interfaces\AuthInterface;
use App\Models\Admin;

class AdminRepositories implements AuthInterface
{
    public $admin;

    public function __construct(Admin $admin) {
        $this->admin = $admin;
    }

    public function getModel($username)
    {
        return $this->admin->where('email', $username)->first();
    }

    public function getProvider()
    {
        return ProviderType::ADMIN;
    }

    public function commission($data)
    {
        auth()->user()->update(['commission' => $data['commission']]);
    }

    public function getCommission()
    {
        return $this->admin->first()->commission;
    }

    public function tokens()
    {
        return $this->admin->whereNotNull('fcm_token')->pluck('fcm_token');
    }

    public function fcm($data)
    {
        auth()->user()->fcms()->create($data);
    }
}