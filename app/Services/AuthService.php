<?php

namespace App\Services;

use App\Traits\HasAuthentication;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;

class AuthService{

    use HasAuthentication;

    private $authRepo;
    
    public function __construct($authRepo) {
        $this->authRepo = $authRepo;
    }

    public function login($data, $auth, $provider) // login in service
    {
        if (!$user = $this->checkUser($data)) {
            return abort(response()->json(["error" => ["invalid credentials"]], Response::HTTP_UNAUTHORIZED));
        }
        $token = $this->tokenRequest($auth, $data, $provider);
        if ($token['statusCode'] == Response::HTTP_OK) {
            $result['user'] = $user;
            $result['token'] = $token['response'];
            return $result;
        }
    }

    public function checkUser($data)
    {
        $user = $this->authRepo->findForPassport($data['email']);
        if ($user && Hash::check($data['password'], $user->password)) {
            return $user;
        }
    }
}