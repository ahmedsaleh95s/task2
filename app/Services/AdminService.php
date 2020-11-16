<?php

namespace App\Services;

use App\Repositories\AdminRepositories;

class AdminService
{
    private $adminRepo;

    public function __construct(AdminRepositories $adminRepo) {
        $this->adminRepo = $adminRepo;
    }

    public function commission($data)
    {
        $this->adminRepo->commission($data);
    }
}