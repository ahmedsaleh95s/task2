<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use Symfony\Component\HttpFoundation\Response;

class NotificationService
{

    private $userRepo;

    public function __construct(UserRepositories $userRepo) {
        $this->userRepo = $userRepo;
    }   

    public function all()
    {
        $this->userRepo->allNotifications();
    }

    public function store($data)
    {
        $this->userRepo->sendNotification($data);
    }

    public function setAsRead($id)
    {
        $this->userRepo->setAsRead($id);
    }

    public function setAllAsRead()
    {
        $this->userRepo->setAllAsRead();
    }

    public function destroy($id)
    {
        $this->userRepo->destroyNotification($id);
    }

    public function delete()
    {
        $this->userRepo->deleteNotifications();
    }
}