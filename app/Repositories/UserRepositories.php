<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Support\Str;

class UserRepositories implements AuthInterface
{
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function store($data)
    {
        $this->user = $this->user->create($data);
    }

    public function saveImage($link)
    {
        $this->user->image()->create($link);
    }

    public function resetPassword($data)
    {
        $user = $this->user->where('email', $data['email'])
        ->where('remember_token', $data['token'])->first();
        if (!$user) {
            return abort(response()->json(["error" => ["invalid credentials"]]));
        }
        $user->update(['password' => $data['password'], 'remember_token' => null]);
        $user->tokens()->delete();
    }

    public function findForPassport($username)
    {
        return $this->user->findForPassport($username);
    }

    public function getBy($column, $value)
    {
        return $this->user->where($column, $value)->first();
    }

    public function saveRememberToken($user)
    {
        $token = Str::random(60);
        $user->update(['remember_token' => $token]);
        return $token;
    }

    public function setProvider()
    {
        return "users";
    }
}