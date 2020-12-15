<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNotificationRequest;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    //

    private $notificationService;

    public function __construct(NotificationService $notificationService) {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = $this->notificationService->all();
        return $notifications; // resource
    }

    public function store(StoreNotificationRequest $request)
    {
        $this->notificationService->store($request->all());
        return response()->json(["message" => "success"])
        ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show()
    {
        $notifications = $this->notificationService->all();
        return $notifications; // resource
    }

    public function setAsRead($id)
    {
        $this->notificationService->setAsRead($id);
        return response()->json(["message" => "success"]);
    }

    public function setAllAsRead()
    {
        $this->notificationService->setAllAsRead();
        return response()->json(["message" => "success"]);
    }

    public function destroy($id)
    {
        $this->notificationService->destroy($id);
        return response()->json(["message" => "success"]);
    }

    public function delete()
    {
        $this->notificationService->delete();
        return response()->json(["message" => "success"]);
    }
}
