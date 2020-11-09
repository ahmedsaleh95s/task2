<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceProviderRequest;
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
}
