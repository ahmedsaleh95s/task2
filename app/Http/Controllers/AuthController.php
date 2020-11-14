<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Psr\Http\Message\ServerRequestInterface;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\ForgetPasswordRequest;
use App\Http\Resources\TokenResource;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\ServiceProviderResource;
use App\Services\ServiceProviderService;

class AuthController extends Controller
{
    //
    private $authService, $userService, $serviceProviderService;

    public function __construct( UserService $userService, AuthService $authService, ServiceProviderService $serviceProviderService) {
        $this->userService = $userService;
        $this->authService = $authService;
        $this->serviceProviderService = $serviceProviderService;
    }

    public function register(CreateUserRequest $request)
    {
        $this->userService->store($request->all());
        return response()->json(["message" => "success"])
        ->setStatusCode(Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth);
        return [new UserResource($response['user']), new TokenResource(json_decode($response['token']))];
    }

    public function forgetPassword(ForgetPasswordRequest $request, ServerRequestInterface $auth)
    {
        $this->userService->forgetPassword($request->all(), $auth);
        return response()->json(["message" => "success"]);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $this->userService->resetPassword($request->all());
        return response()->json(["message" => "success"]);
    }

    public function distance()
    {
        $serviceProviders = $this->userService->distance(auth()->user()->location);
        return ServiceProviderResource::collection($serviceProviders);
    }
}
