<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\HasAuthentication;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{

    use HasAuthentication;
    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function login($data, $auth)
    {
        if (!$user = $this->checkUser($data)) {
            return abort(response()->json(["error" => ["invalid credentials"]]));
        }
        $token = $this->tokenRequest($auth, $data);
        if ($token['statusCode'] == Response::HTTP_OK) {
            $result['user'] = $user;
            $result['token'] = $token['response'];
            return $result;
        }
    }

    public function checkUser($data)
    {
        $user = $this->user->findForPassport($data['email']);
        if ($user && Hash::check($data['password'], $user->password)) {
            return $user;
        }
    }
}