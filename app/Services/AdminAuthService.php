<?php

namespace App\Services;

use App\Repositories\AdminRepositories;
use App\Services\AuthService;

class AdminAuthService{


    protected $adminRepo, $authService;
    
    public function __construct(AdminRepositories $adminRepo) {
        $this->adminRepo = $adminRepo;
        $this->authService = new AuthService($adminRepo);
    }

    public function login($data, $auth) // login in service
    {
        return $this->authService->login($data, $auth, "admins");
    }
}