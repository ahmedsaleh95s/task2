<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AdminResource;
use App\Http\Resources\TokenResource;
use App\Http\Requests\AdminLoginRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuthService;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends Controller
{
    //
    private $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(AdminLoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth, "admins");
        return [new AdminResource($response['user']), new TokenResource(json_decode($response['token']))];
    }
}
