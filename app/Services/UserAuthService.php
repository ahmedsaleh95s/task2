<?php

namespace App\Services;

use App\Repositories\UserRepositories;

class UserAuthService{


    private $userRepo, $authService;
    
    public function __construct(UserRepositories $userRepo) {
        $this->userRepo = $userRepo;
        $this->authService = new AuthService($userRepo);
    }

    public function login($data, $auth) // login in service
    {
        return $this->authService->login($data, $auth, null, $this->userRepo);
    }
}