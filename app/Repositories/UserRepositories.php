<?php

namespace App\Repositories;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;

class UserRepositories 
{
    use ImageTrait;
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function store($data)
    {
        $user = $this->user->create($data);
        $this->saveImage($data['photo'], $user, "users");
    }

    public function sendEmail($data)
    {
        $user = $this->user->where('email', $data['email'])->first();
        Mail::to($user)->send(new ForgetPassword());
    }
}