<?php

namespace App\Services;

use App\Repositories\AuthRepository;

class AuthService{

    private $authRepo;
    
    public function __construct(AuthRepository $authRepo) {
        $this->authRepo = $authRepo;
    }


    public function login($data, $auth)
    {
        return $this->authRepo->login($data, $auth);
    }
}