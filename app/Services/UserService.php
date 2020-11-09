<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HasAuthentication;
use Kreait\Firebase\DynamicLinks;
use Kreait\Firebase\DynamicLink\CreateDynamicLink\FailedToCreateDynamicLink;
use App\Traits\ImageTrait;

class UserService
{

    use HasAuthentication;
    use ImageTrait;
    private $userRepo;

    public function __construct(UserRepositories $userRepo, DynamicLinks $dynamicLinks)
    {
        $this->userRepo = $userRepo;
        $this->dynamicLinks = $dynamicLinks;
    }


    public function store($data)
    {
        $this->userRepo->store($data);
        if (!empty($data['photo'])) {
            $link['image'] = $this->uploadImage($data['photo'], "users");
            $this->userRepo->saveImage($link);
        }
    }

    public function forgetPassword($data, $auth)
    {
        $user = $this->userRepo->getBy('email', $data['email']);
        if ($user) {
            $token = $this->userRepo->saveRememberToken($user);
            $link = $this->getDynamicLink($token);
            Mail::to($user)->send(new ForgetPassword($link['shortLink']));
        }
    }

    public function resetPassword($data)
    {
        $this->userRepo->resetPassword($data);
    }

    public function getDynamicLink($token)
    {
        $url = config('app.url') . ":" . config('app.port') . "?token=" . $token;
        try {
            $link = $this->dynamicLinks->createShortLink($url);
        } catch (FailedToCreateDynamicLink $e) {
            echo $e->getMessage();
            exit;
        }
    }
}
