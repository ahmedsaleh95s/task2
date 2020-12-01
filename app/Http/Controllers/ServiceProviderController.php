<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceProvidersDataTable;
use App\Enums\ReservationStatus;
use App\Http\Requests\ServiceProviderLoginRequest;
use Illuminate\Http\Request;
use App\Http\Requests\StoreServiceProviderRequest;
use App\Http\Requests\UpdateServiceProviderRequest;
use App\Http\Resources\IntervalResource;
use App\Http\Resources\ServiceProviderResource;
use App\Services\ServiceProviderService;
use Symfony\Component\HttpFoundation\Response;
use Psr\Http\Message\ServerRequestInterface;
use App\Http\Resources\TokenResource;
use App\Services\AuthService;
use App\Models\ServiceProvider;
use App\Interfaces\AuthInterface;
use Yajra\Datatables\Datatables;
use App\Http\Requests\GetServiceProviderRequest;
use CategoryServiceProviderTable;
use Yajra\DataTables\CollectionDataTable;

class ServiceProviderController extends Controller
{
    //
    private $serviceProviderService, $authService, $authInterface, $dataTable;

    public function __construct(ServiceProviderService $serviceProviderService, AuthService $authService, AuthInterface $authInterface, ServiceProvidersDataTable $dataTable)
    {
        $this->authorizeResource(ServiceProvider::class, 'serviceProvider');
        $this->serviceProviderService = $serviceProviderService;
        $this->authService = $authService;
        $this->authInterface = $authInterface;
        $this->dataTable = $dataTable;
    }

    public function store(StoreServiceProviderRequest $request)
    {
        $this->serviceProviderService->store($request->all());
        return response()->json(["message" => "success"])
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function index()
    {
        $serviceProviders = $this->serviceProviderService->all();
        return Datatables::of(ServiceProviderResource::collection($serviceProviders))
            ->make(true);
    }

    public function show(ServiceProvider $serviceProvider)
    {
        if (request()->ajax()) {
            $collection = $serviceProvider->getIntervals();
            return DataTables::of($collection)
                ->addColumn('action', function () use ($serviceProvider) {
                    return '<button type="submit" id="' . $serviceProvider->id . '" style="margin-top: 1%;" class="btn btn-info col-12">RESERVE</button>';
                })
                ->toJson();
        }
        return $this->dataTable->render('service-providers.details');
    }

    public function update(UpdateServiceProviderRequest $request, ServiceProvider $serviceProvider)
    {
        $this->serviceProviderService->update($request->all(), $serviceProvider);
        return response()->json(["message" => "success"]);
    }

    public function destroy(ServiceProvider $serviceProvider)
    {
        $this->serviceProviderService->delete($serviceProvider);
        return response()->json(["message" => "success"]);
    }

    public function login(ServiceProviderLoginRequest $request, ServerRequestInterface $auth)
    {
        $response = $this->authService->login($request->all(), $auth, $this->authInterface);
        return [new ServiceProviderResource($response['user']), new TokenResource(json_decode($response['token']))];
    }

    public function distance(GetServiceProviderRequest $request)
    {
        $serviceProviders = $this->serviceProviderService->distance($request->all());
        return DataTables::of(ServiceProviderResource::collection($serviceProviders))->toJson();
    }
}
