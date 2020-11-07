<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HasAuthentication;

class UserService
{

    use HasAuthentication;
    private $userRepo;

    public function __construct(UserRepositories $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function store($data)
    {
        $this->userRepo->store($data);
    }

    public function forgetPassword($data, $auth)
    {
        $user = $this->userRepo->user->where('email', $data['email'])->first();
        if ($user) {
            $data['password'] = $user->password;
            $link = $this->getDynamicLink($data, $auth);
            Mail::to($user)->send(new ForgetPassword($link['shortLink']));
        }
    }

    public function resetPassword($data)
    {
        $this->userRepo->resetPassword($data);
    }

    public function getDynamicLink($data, $auth)
    {
        $result = $this->tokenRequest($auth, $data);
        $token = (json_decode($result['response'], true)['access_token']);
        $response = Http::post( config('app.firebase-dynamic-link') .'?key=' . config('app.firebase-key'), [
            'longDynamicLink' => config('app.dynamic-link-prefix') ."?link=". config('app.url'). ":" . config('app.port')."?token=". $token . config('app.dynamic-link-ios-android-config'),
        ]);

        if ($response->status() == Response::HTTP_OK) {
            return json_decode($response->body(), true);
        }
        return abort(response()->json(["error" => ["Failed To Generate Code"]]));
    }
}
