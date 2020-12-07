<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminResource;
use App\Http\Resources\TokenResource;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\StoreAdminCommisionRequest;
use App\Http\Requests\StoreFcmTokenRequest;
use App\Interfaces\AuthInterface;
use App\Services\AdminService;
use Symfony\Component\HttpFoundation\Response;
use App\Services\AuthService;
use Psr\Http\Message\ServerRequestInterface;

class AdminController extends Controller
{
    //
    private $authService, $adminService , $authInterface;

    public function __construct(AuthInterface $authInterface, AdminService $adminService, AuthService $authService) {
        $this->authService = $authService;
        $this->adminService = $adminService;
        $this->authInterface = $authInterface;
    }

    public function login(AdminLoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth, $this->authInterface);
        $result['user'] = new AdminResource($response['user']);
        $result['token'] = new TokenResource(json_decode($response['token']));
        return $result;
    }

    public function commission(StoreAdminCommisionRequest $request)
    {
        $this->adminService->commission($request->all());
        return response()->json(["message" => "success"])
        ->setStatusCode(Response::HTTP_CREATED);
    }

    public function fcm(StoreFcmTokenRequest $request)
    {
        $this->adminService->fcm($request->all());
        return response()->json(["message" => "success"]);
    }
}
