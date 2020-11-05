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

class AuthController extends Controller
{
    //
    private $authService, $userService;

    public function __construct( UserService $userService, AuthService $authService) {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function register(CreateUserRequest $request)
    {
        $this->userService->store($request->all());
        return response()->json("success")->setStatusCode(Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth);
        return new UserResource($response['user'], $response['token']);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return $this->userService->forgetPassword($request->all());
        return response()->json("success");
    }
}
