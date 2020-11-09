<?php

namespace App\Repositories;
use App\Models\Admin;

class AdminRepositories 
{
    public $admin;

    public function __construct(Admin $admin) {
        $this->admin = $admin;
    }

    public function findForPassport($username)
    {
        return $this->admin->where('email', $username)->first();
    }
}