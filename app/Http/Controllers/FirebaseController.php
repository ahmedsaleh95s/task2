<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFirebaseNodeRequest;
use App\Http\Requests\UpdateFirebaseNodeRequest;
use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FirebaseController extends Controller
{
    //
    private $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        return $nodes = $this->firebaseService->all();
    }

    public function store(StoreFirebaseNodeRequest $request)
    {
        $this->firebaseService->store($request->all());
        return response()->json(["message" => "success"])
            ->setStatusCode(Response::HTTP_CREATED); 
    }

    public function update(UpdateFirebaseNodeRequest $request ,$node)
    {
        $this->firebaseService->update($request->all(), $node);
        return response()->json(["message" => "success"]);
    }

    public function destroy($node)
    {
        $this->firebaseService->destroy($node);
        return response()->json(["message" => "success"]);
    }
}
