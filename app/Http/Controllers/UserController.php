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
use App\Http\Requests\UserReservationRequest;
use App\Http\Resources\ServiceProviderResource;
use App\Models\ServiceProvider;
use App\Services\ServiceProviderService;
use App\Interfaces\AuthInterface;
use App\Models\User;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    //
    private $authService, $userService, $authInterface;

    public function __construct( UserService $userService, AuthService $authService, AuthInterface $authInterface) {
        $this->userService = $userService;
        $this->authService = $authService;
        $this->authInterface = $authInterface;
    }

    public function login(LoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth, $this->authInterface);
        $result['user'] = new UserResource($response['user']);
        $result['token'] = new TokenResource(json_decode($response['token']));
        return $result;
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

    public function reservation(UserReservationRequest $request, ServiceProvider $serviceProvider)
    {
        return $this->userService->reservation($request->all(), $serviceProvider);
        return response()->json(["message" => "success"])
        ->setStatusCode(Response::HTTP_CREATED);
    }

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('users.index');
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(CreateUserRequest $request)
    {
        $this->userService->store($request->all());
        return response()->json(["message" => "success"])
        ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($request->all(), $user);
        return response()->json(["message" => "success"]);
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user);
        return response()->json(["message" => "success"]);
    }
}
