<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceProviderLoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceProviderRequest;
use App\Http\Requests\UpdateServiceProviderRequest;
use App\Http\Resources\ServiceProviderResource;
use App\Services\ServiceProviderService;
use Symfony\Component\HttpFoundation\Response;
use Psr\Http\Message\ServerRequestInterface;
use App\Http\Resources\TokenResource;
use App\Services\AuthService;
use App\Models\ServiceProvider;

class ServiceProviderController extends Controller
{
    //
    private $serviceProviderService, $authService;
    
    public function __construct(ServiceProviderService $serviceProviderService, AuthService $authService) {
        $this->serviceProviderService = $serviceProviderService;
        $this->authService = $authService;
    }

    public function store(StoreServiceProviderRequest $request)
    {
        $this->serviceProviderService->store($request->all());
        return response()->json(["message" => "success"])
        ->setStatusCode(Response::HTTP_CREATED);
    }

    public function all()
    {
        $serviceProviders = $this->serviceProviderService->all();
        return ServiceProviderResource::collection($serviceProviders);
    }

    public function show(ServiceProvider $serviceProvider)
    {
        return new ServiceProviderResource($serviceProvider);
    }

    public function update(UpdateServiceProviderRequest $request, ServiceProvider $serviceProvider)
    {
        $this->serviceProviderService->update($request->all(), $serviceProvider);
        return response()->json(["message" => "success"]);
    }

    public function delete(ServiceProvider $serviceProvider)
    {
        $this->serviceProviderService->delete($serviceProvider);
        return response()->json(["message" => "success"]);
    }

    public function login(ServiceProviderLoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth);
        return [new ServiceProviderResource($response['user']), new TokenResource(json_decode($response['token']))];
    }
}
