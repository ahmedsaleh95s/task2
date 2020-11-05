<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\HasAuthentication;
use Symfony\Component\HttpFoundation\Response;

class AuthRepository
{

    use HasAuthentication;
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login($data, $auth)
    {
        $data = $this->checkLoginType($data);
        $token = $this->tokenRequest($auth, $data);
        if ($token['statusCode'] == Response::HTTP_OK) {
            $result['user'] = $this->user->where('email', $data['email'])->first();
            $result['token'] = $token['response'];
            return $result;
        }
        return response()->json(["error" => ["invalid credentials"]]);
    }

    public function checkLoginType($data)
    {
        if (empty($data['email'])) {
            $data['email'] = $this->user->where('phone', $data['phone'])->first()->email;
        }
        return $data;
    }
}