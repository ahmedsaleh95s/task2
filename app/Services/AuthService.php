<?php

namespace App\Services;

use App\Interfaces\AuthInterface;
use App\Traits\HasAuthentication;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Repositories\AdminRepositories;
use Exception;

use function PHPUnit\Framework\throwException;

class AuthService
{

    use HasAuthentication;

    private $authInterface;
    
    public function __construct(AuthInterface $authInterface) {
        $this->authInterface = $authInterface;
    }

    public function login($data, $auth) // login in service
    {
        $token = $this->tokenRequest($auth, $data, $this->authInterface->getProvider());
        if ($token['statusCode'] == Response::HTTP_OK) {
            $result['user'] = $this->authInterface->getModel($data['email']);
            $result['token'] = $token['response'];
            return $result;
        }
    }
}