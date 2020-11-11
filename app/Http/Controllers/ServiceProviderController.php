<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceProviderRequest;
use App\Http\Requests\UpdateServiceProviderRequest;
use App\Http\Resources\ServiceProviderResource;
use App\Services\ServiceProviderService;
use Symfony\Component\HttpFoundation\Response;

class ServiceProviderController extends Controller
{
    //
    private $serviceProviderService;
    
    public function __construct(ServiceProviderService $serviceProviderService) {
        $this->serviceProviderService = $serviceProviderService;
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

    public function show($id)
    {
        $serviceProvider = $this->serviceProviderService->show($id);
        return new ServiceProviderResource($serviceProvider);
    }

    public function update(UpdateServiceProviderRequest $request, $id)
    {
        $this->serviceProviderService->update($request->all(), $id);
        return response()->json(["message" => "success"]);
    }
}
