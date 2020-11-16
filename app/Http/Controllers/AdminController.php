<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AdminResource;
use App\Http\Resources\TokenResource;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\StoreAdminCommisionRequest;
use App\Services\AdminService;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuthService;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends Controller
{
    //
    private $authService, $adminService;

    public function __construct(AuthService $authService, AdminService $adminService) {
        $this->authService = $authService;
        $this->adminService = $adminService;
    }

    public function login(AdminLoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth);
        return [new AdminResource($response['user']), new TokenResource(json_decode($response['token']))];
    }

    public function commission(StoreAdminCommisionRequest $request)
    {
        $this->adminService->commission($request->all());
        return response()->json(["message" => "success"])
        ->setStatusCode(Response::HTTP_CREATED);
    }
}
