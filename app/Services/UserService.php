<?php

namespace App\Services;
use App\Repositories\UserRepositories;

class UserService {

    private $userRepo;
    
    public function __construct(UserRepositories $userRepo) {
        $this->userRepo = $userRepo;
    }


    public function store($data)
    {
        $this->userRepo->store($data);
    }

    public function forgetPassword($data)
    {
        $this->userRepo->sendEmail($data);
    }
}